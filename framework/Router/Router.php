<?php
	
namespace Framework\Router;

use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;

class Router
{
	
	/**
	 * @var array routing map.
	 */
	protected $map = array();
	
	/**
	 * @var array route.
	 */
	protected $route = array();
	
	/**
	 * @param array $routing_map.
	 * @return void.
	 */
	public function __construct($routing_map)
	{
		$this->map = $routing_map;
	}	
	
	/**
	 * @param string $name name of route.
	 * @param array $params parameters of route.
	 * @return string route.
	 */
	public function buildRoute($name, $params = array())
	{				
		$routePattern = $this->map[$name]['pattern'];
		if(!empty($params)){
			foreach($params as $key => $val){
				
				$routePattern = str_replace('{' . $key . '}', $val, $routePattern);
			}
		}
		return 'http://' . $_SERVER['SERVER_NAME'] . $routePattern;
	}
	
	/**
	 * Searching of route in routing map by uri.
	 * @param string $uri.
	 * @return array match route.
	 */
	public function find($uri)
	{				
		$match_route = null;		
		
		if(!empty($this->map)){
			foreach($this->map as $name => $route){				
				$requirements = isset($route['_requirements']) ? $route['_requirements'] : array();
				$pattern = $this->patternToRegexp($route['pattern'], $requirements);	
			
				if(preg_match($pattern, $uri)){
					
						# check METHOD
					if(isset($requirements['_method']) && $requirements['_method'] != Service::get('request')->getMethod()){
						//throw new HttpNotFoundException('Need ' . $requirements['_method'] . ' method!');
					}				
					$match_route = $route;
					$match_route['_name'] = $name;
						# parsing				
					$uri_explode = explode('/', $uri);					
					
					if(count($uri_explode) > 2){
						$route_pattern = str_replace(array('}', '{'), array('', ''), $route['pattern']);
						$route_explode = explode('/', $route_pattern);
						
						$params = array();
						for($i=2;$i<count($uri_explode);$i++){
							if(empty($route_explode[$i])){
								continue;
							}
							if($uri_explode[$i] == $route_explode[$i]){
								$params[$route_explode[$i]] = true;
							}
							else{
								$params[$route_explode[$i]] = $uri_explode[$i];
							}
						}						
						$match_route['parameters'] = $params; // from parsing
					}
					break; //совпадение найдено 
				}
			}			
		}
		return $this->route = $match_route;
	}
	
	/**
	 * @retur array.
	 */
	public function getRoute()
	{
		return $this->route;
	}
	
	/**
	 * @param string pattern.
	 * @param array.
	 * @return string regular expressions.
	 */
	protected function patternToRegexp($pattern, $requirement = array())
	{
		if(!empty($requirement)){
			foreach($requirement as $key => $val){
				if($key == '_method'){
					continue;
				}
			$pattern = str_replace('{' . $key . '}', $val, $pattern);
			}			
		}
		$pattern = preg_replace('~\{[\w\d_]+\}~', '[\w\d_]+', $pattern);
		$pattern = str_replace('/', '\\/', $pattern);
		$regexp = '~^' . $pattern . '\/*$~i';
		return $regexp;
	}
	
}