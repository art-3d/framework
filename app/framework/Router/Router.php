<?php

namespace Framework\Router;

use Framework\DI\Service;

class Router
{
	protected array $route = [];

	public function __construct(private array $map)
	{
	}
	/**
	 * @param string $name name of route.
	 * @param array $params parameters of route.
	 * @return string route.
	 */
	public function buildRoute($name, $params = [])
	{
		$routePattern = $this->map[$name]['pattern'];
		if (!empty($params)) {
			foreach($params as $key => $val) {
				$routePattern = str_replace('{' . $key . '}', $val, $routePattern);
			}
		}
		return 'http://' . $_SERVER['SERVER_NAME'] . ':8002' . $routePattern;
	}
	/**
	 * Searching of route in routing map by uri.
	 * @param string $uri.
	 * @return array match route.
	 */
	public function find($uri)
	{
		$match_route = null;
		if (!empty($this->map)) {
			foreach($this->map as $name => $route) {
				$requirements = isset($route['_requirements']) ? $route['_requirements'] : [];
				$pattern = $this->patternToRegexp($route['pattern'], $requirements);
				if (preg_match($pattern, $uri)) {
						# check METHOD
					if (isset($requirements['_method']) && $requirements['_method'] != Service::get('request')->getMethod()) {
						//throw new HttpNotFoundException('Need ' . $requirements['_method'] . ' method!');
					}
					$match_route = $route;
					$match_route['_name'] = $name;
						# parsing
					$uri_explode = explode('/', $uri);
					if (count($uri_explode) > 2) {
						$route_pattern = str_replace(['}', '{'], ['', ''], $route['pattern']);
						$route_explode = explode('/', $route_pattern);
						$params = [];
						for($i=2;$i<count($uri_explode);$i++) {
							if (empty($route_explode[$i])) {
								continue;
							}
							if ($uri_explode[$i] === $route_explode[$i]) {
								$params[$route_explode[$i]] = true;
							}
							else{
								$params[$route_explode[$i]] = $uri_explode[$i];
							}
						}
						$match_route['parameters'] = $params; // from parsing
					}
					break; // no match found
				}
			}
		}
		return $this->route = $match_route;
	}

	public function getRoute(): array
	{
		return $this->route;
	}
	/**
	 * @param string pattern.
	 * @param array.
	 * @return string regular expressions.
	 */
	protected function patternToRegexp($pattern, $requirement = [])
	{
		if (!empty($requirement)) {
			foreach($requirement as $key => $val) {
				if ($key === '_method') {
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
