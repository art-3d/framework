<?php

namespace Framework;

use Framework\Router\Router;
use Framework\DI\Service;
use Framework\Request\Request;
use Framework\Renderer\Renderer;
use Framework\Exception\HttpNotFoundException;
use Framework\Session\Session;
use Framework\Security\Security;
use Framework\Response\Response;

class Application
{
	public array $config;

	public function __construct(string $configPath)
	{
		$this->config = include_once($configPath);

		Service::set('application', $this);
		Service::set('router', new Router($this->config['routes']));
		Service::set('request', new Request());
		Service::set('renderer', new Renderer());
		Service::set('session', new Session());
		Service::set('security', new Security());

		Service::set('pdo', new \PDO(
			$this->config['pdo']['dsn'],
			$this->config['pdo']['user'],
			$this->config['pdo']['password'],
			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC],
		));
	}

	public function run()
	{
		try{
			if ($token = Service::get('request')->post('token')) { 
				if ($_COOKIE['token'] != $token) {
					throw new \Exception('Wrong token!');
				}	
			}
			if ($route = Service::get('router')->find($_SERVER['REQUEST_URI'])) {
					// check security
				if (isset($route['security'])) {
					if (!Service::get('security')->isAuthenticated()) {
						throw new \Exception('You don\'t have permission to access on this server');
					}
				}
				$controller = $route['controller'];
				$action = $route['action'] . 'Action';
				$this->config['controller'] = $controller;
				$controllerReflection = new \ReflectionClass($controller);
				if ($controllerReflection->hasMethod($action)) {
					$args = isset($route['parameters']) ? $route['parameters'] : [];
					$response = (new $controller)->$action($args);

					// $reflectionMethod = new \ReflectionMethod($controller, $action);
					// $args = isset($route['parameters']) ? $route['parameters'] : [];
					// $response = $reflectionMethod->invokeArgs(new $controller, $args);

					if (is_subclass_of($response, 'Framework\Response\ResponseInterface')) {
						if ($response->type === 'html') {
							$response->send();
						}
					}
				} else {
					// the action is not found
					throw new HttpNotFoundException('Page Not Found!');
				}
			} else {
				// the route is not found
				throw new HttpNotFoundException('Page Not Found!');
			}
		} catch (\Exception $e ) {
			$errors = ['message' => $e->getMessage(), 'code' => $e->getCode()];
			$path_500 = str_replace('\\', '/', __DIR__ . '/../src/Blog/views/500.html.php');
			$response = new Response(Service::get('renderer')->render($path_500, $errors, true));
			$response->send();
		}
	}	
}
