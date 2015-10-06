<?php
	
namespace Framework\Router;

use Framework\DI\Service;

class Router
{
	protected $map = array();
	
	public function __construct($routing_map){
		$this->map = $routing_map;
	}	
	
	public function buildRoute($index, $params = array()){
		
		$routePattern = $this->map[$index]['pattern'];
		if(!empty($params)){
			foreach($params as $key => $val){
				$routePattern = str_replace('{' . $key . '}', $val, $routePattern);
			}
		}
		return 'http://' . $_SERVER['SERVER_NAME'] . $routePattern;
	}
	
	public function find($uri){
		
		$uri = substr($uri, 4); // DELETE THIS
		
		$match_route = null;
		
		if(!empty($this->map)){
			foreach($this->map as $route){
				$pattern = $this->patternToRegexp($route['pattern'], $route['_requirements']);	
				if(preg_match($pattern, $uri)){
					// CHECK METHOD					
					
					$match_route = $route;
					
					// parsing					
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
					break;
				}
			}			
		}
		return $match_route;
	}
	
	protected function getMethod(){
		return $_SERVER['REQUEST_METHOD'];
	}
	
	protected function patternToRegexp($pattern, $requirement = array()){
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