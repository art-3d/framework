<?php

namespace Framework\Controller;

use Framework\Response\ResponseRedirect;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\DI\Service;

abstract class Controller
{	
    /**
     * @param string $view.
     * @param array $params parameters of this view.
     * @return object new Response.
	 */
	public static function render($view, $params = [])
	{
		$renderer = Service::get('renderer');

		return new Response($renderer->render($view, $params));
	}

	/**
	 * @return object Request.
	 */
	public function getRequest()
	{
		return Service::get('request');
	}

	/**
	 * Save returnURI and message, redirecting.
	 * @param string $url uri redirect to.
	 * @param string $message save the message in the session.
	 * @return void.
	 */
	public function redirect($url, $message = '')
	{
		$session = Service::get('session');
		$session->returnURI = Service::get('request')->getURI();
		if (!empty($message)) {
			$session->set('message', ['info' => [$message]]);
		}
		new ResponseRedirect($url);
	}
	/**
	 * @param string $name the name of route.
	 * @param array $parameters  the parameters of route.
	 * @return string route.
	 */
	public function generateRoute($name, $parameters = [])
	{
		return Service::get('router')->buildRoute($name, $parameters);
	}

}