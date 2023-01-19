<?php

declare(strict_types=1);

namespace Framework\Controller;

use Framework\DataBase\Connection;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Response\ResponseInterface;
use Framework\Response\ResponseRedirect;
use Framework\Router\Router;
use Framework\Security\Security;
use Framework\Session\Session;

abstract class Controller
{
    public function __construct(
        protected Renderer $renderer,
        protected Request $request,
        protected Session $session,
        protected Router $router,
        protected Security $security,
        protected Connection $connection,
    ) {
    }

    public function render(string $view, array $params = []): ResponseInterface
    {
        return new Response($this->renderer->render($view, $params));
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function redirect(string $url, string $message = null): ResponseInterface
    {
        $this->session->returnUrl = $this->request->getURI();

        if (!empty($message)) {
            $this->session->writeInfo($message);
        }

        return new ResponseRedirect($url);
    }

    public function generateRoute(string $name, array $parameters = []): string
    {
        return $this->router->buildRoute($name, $parameters);
    }
}
