<?php

declare(strict_types=1);

namespace Framework\Renderer;

use Framework\Application\WebApplication;
use Framework\Controller\Controller;
use Framework\DI\Container;
use Framework\Request\Request;
use Framework\Response\ResponseInterface;
use Framework\Router\Router;
use Framework\Session\Session;

class Renderer
{
    protected string $view;
    protected array $parameters;

    public function __construct(
        private WebApplication $app,
        private string $mainLayoutPath,
        private Session $session,
        private Router $router,
        private Request $request,
        private Container $container,
    ) {
    }

    /**
     * @return string content of requested view
     */
    public function render(string $view, array $parameters = [], bool $absolute_path = false): string
    {
        $this->view = $view;
        $this->parameters = $parameters;
        $viewPath = $absolute_path ? $view : $this->getView($this->app->getControllerClass());

        // Closures block ******************
        $action = $this->request->getURI();
        $getRoute = function ($item, $param = []) {
            return $this->router->buildRoute($item, $param);
        };
        $include = function (string $controllerName, string $action, array $params = []): void {
            $action .= 'Action';

            /** @var Controller $controller */
            $controller = $this->container->build($controllerName);

            /** @var ResponseInterface $response */
            $response = $controller->{$action}(...$params);
            $response->send();
        };
        $generateToken = function (): void {
            $token = md5(date('G/i/s'));
            setcookie('token', $token);
            echo '<input type="hidden" name="token" value="'.$token.'" />';
        };
            // End closures block **************
        $route = $this->router->getRoute(); // array
        $user = $this->session->getUser();

        if ($flush = $this->session->get('message')) {
            $flush = json_decode($flush, true);
            $this->session->delete('message');
        } else {
            $flush = [];
        }
        ob_start();
        extract($this->parameters);

        include $viewPath;
        $content = ob_get_clean();
        // Rendering into main template
        ob_start();

        include $this->mainLayoutPath;

        return ob_get_clean();
    }

    protected function getView(string $controller): string
    {
        $view_path = preg_replace('/Controller/', 'views', $controller, 1);
        $view_path = __DIR__.'/../../src/'.str_replace('Controller', '', $view_path).'\\'.$this->view.'.php';

        return str_replace('\\', '/', $view_path);
    }
}
