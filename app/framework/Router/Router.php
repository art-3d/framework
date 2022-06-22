<?php

namespace Framework\Router;

use Framework\Request\Request;

class Router
{
	protected array $route = [];

	public function __construct(
		private array $routeMap,
		private Request $request,
	) {
	}

	public function buildRoute(string $name, array $params = []): string
	{
		$routePattern = $this->routeMap[$name]['pattern'];
		if (!empty($params)) {
			foreach ($params as $key => $val) {
				$routePattern = str_replace('{' . $key . '}', $val, $routePattern);
			}
		}

		return 'http://' . $_SERVER['SERVER_NAME'] . ':8002' . $routePattern;
	}

	public function find(string $uri): ?array
	{
		$match_route = null;
		foreach ($this->routeMap as $name => $route) {
			$requirements = isset($route['_requirements']) ? $route['_requirements'] : [];
			$pattern = $this->patternToRegexp($route['pattern'], $requirements);
			if (preg_match($pattern, $uri)) {
					# check METHOD
				if (isset($requirements['_method']) && $requirements['_method'] !== $this->request->getMethod()) {
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
					// for ($i=2; $i < count($uri_explode); $i++) {
					// 	if (empty($route_explode[$i])) {
					// 		continue;
					// 	}
					// 	if ($uri_explode[$i] === $route_explode[$i]) {
					// 		$params[$route_explode[$i]] = true;
					// 	} else {
					// 		$params[$route_explode[$i]] = $uri_explode[$i];
					// 	}
					// }
					$match_route['parameters'] = $params; // from parsing
				}
				break; // no match found
			}
		}

		return $this->route = $match_route;
	}

	public function getRoute(): array
	{
		return $this->route;
	}

	protected function patternToRegexp(string $pattern, array $requirement = []): string
	{
		if (!empty($requirement)) {
			foreach ($requirement as $key => $val) {
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
