<?php

namespace Framework\Controller;

use Framework\Response\ResponseRedirect;
use Framework\Response\Response;
use Framework\DI\Service;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Response\ResponseInterface;

abstract class Controller
{	
	public function __construct(protected Renderer $renderer)
	{
	}

	public function render(string $view, array $params = []): ResponseInterface
	{
		// $renderer = Service::get('renderer');

		return new Response($this->renderer->render($view, $params));
	}

	public function getRequest(): Request
	{
		return Service::get('request');
	}

	public function redirect(string $url, string $message = null): ResponseInterface
	{
		$session = Service::get('session');
		$session->returnURI = Service::get('request')->getURI();
		if (!empty($message)) {
			$session->set('message', ['info' => [$message]]);
		}

		return new ResponseRedirect($url);
	}

	public function generateRoute(string $name, array $parameters = []): string
	{
		return Service::get('router')->buildRoute($name, $parameters);
	}
}