<?php

declare(strict_types=1);

namespace Framework\Application;

use Framework\DI\Container;
use Framework\Exception\HttpNotFoundException;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Router\Router;
use Framework\Security\Security;

final class WebApplication extends Application
{
	private string $controllerClass;
	private Request $request;
	private Router $router;
	private Security $security;
	private Renderer $renderer;

	public function __construct(
		private Container $container,
	) {
		$container->add(self::class, $this);
		$this->request = $container->build(Request::class);
		$this->router = $container->build(Router::class);
		$this->security = $container->build(Security::class);
		$this->renderer = $container->build(Renderer::class);
	}

	public function run(): void
	{
		try {
			if ($token = $this->request->post('token')) {
				if ($_COOKIE['token'] !== $token) {
					throw new \Exception('Wrong token!');
				}
			}
			if ($route = $this->router->find($_SERVER['REQUEST_URI'])) {
					// check security
				if (isset($route['security']) && !$this->security->isAuthenticated()) {
                    throw new \Exception('You don\'t have permission to access on this server');
				}
				$controllerClass = $route['controller'];
				$action = $route['action'] . 'Action';
				$this->controllerClass = $controllerClass;

				$controller = $this->container->build($controllerClass);
				if (method_exists($controller, $action)) {
					$reflectionMethod = new \ReflectionMethod($controllerClass, $action);
					$args = isset($route['parameters']) ? $route['parameters'] : [];
					$response = $reflectionMethod->invokeArgs($controller, $args);
					$response->send();
				} else {
					throw new HttpNotFoundException('Page Not Found');
				}
			} else {
				// the route is not found
				throw new HttpNotFoundException('Page Not Found!');
			}
		} catch (\Exception $e ) {
			$errors = ['message' => $e->getMessage(), 'code' => $e->getCode()];
			$templatePath = str_replace('\\', '/', __DIR__ . '/../../src/Blog/views/500.html.php');
			$response = new Response(
				$this->renderer->render($path, $errors, true)
			);
			$response->send();
		}
	}

	public function getControllerClass(): string
	{
		return $this->controllerClass;
	}
}
