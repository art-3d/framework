<?php

namespace Framework\Renderer;

use Framework\DI\Container;
use Framework\DI\Service;

class Renderer
{
	protected string $view;
	protected array $parameters;

	public function __construct(
		private string $mainLayoutPath,
		private Container $container,
	) {
	}

	protected function getView(string $controller): string
    {
		$view_path = preg_replace('/Controller/', 'views', $controller, 1);
		$view_path = __DIR__ . '/../../src/' . str_replace('Controller', '', $view_path) . '\\' . $this->view . '.php';

		return str_replace('\\', '/', $view_path);
	}
	/**
	 * @param string $view.
	 * @param array $parameters.
	 * @return string content of requested view.
	 */
	public function render(string $view, array $parameters = [], bool $absolute_path = false): string
	{
		$this->view = $view;
		$this->parameters = $parameters;
		$app = Service::get('application');
		$router = Service::get('router');
		$session = Service::get('session');
		// $mainLayoutPath = $app->config['main_layout'];
		$viewPath = $absolute_path ? $view : $this->getView($app->config['controller']);

			# Closures block ******************
		$getRoute = function($item, $param = []) use (&$router) {
			return $router->buildRoute($item, $param);
		};
		$include = function($controller, $action, $params = []): void {
			// $action .= 'Action';
			// $ctrl = new $controller;
			// $refl = new \ReflectionMethod($ctrl, $action);
			// $response = $refl->invokeArgs($ctrl, $params);
			// $response->send();
			
			
			$action .= 'Action';
			$controller = $this->container->make($controller);
			$response = $controller->$action($params);
			$response->send();
		};
		$generateToken = function(): void {
			$token = md5(date('G/i/s'));
			setcookie('token', $token);
			echo '<input type="hidden" name="token" value="' . $token . '" />'; 
		};
			# End closures block **************
		$route = Service::get('router')->getRoute(); // array
		$user = Service::get('session')->get('user'); // object
		if ($flush = $session->get('message')) {
			$session->delete('message');
		} else {
			$flush = [];
		}
		ob_start();
		extract($this->parameters);
		include($viewPath);
		$content = ob_get_clean();
			# Rendering into main template
		ob_start();
		include($this->mainLayoutPath);

		return ob_get_clean();
	}
}