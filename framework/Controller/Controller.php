<?php
	
namespace Framework\Controller;

use Framework\Response\ResponseRedirect;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\DI\Service;

abstract class Controller
{	

    /**
     * @param string view.
     * @param array parameters of this view.
     * @return object new Response.
	 */		
	public static function render($view, $params = array()){
		
		$renderer = new Renderer($view, $params);
		return new Response($renderer->render());
	}	

	/**
	 * @return object Request.
	 */
	public function getRequest(){
			
		return Service::get('request');
	}

	/**
	 * Save returnURI and message, redirecting.
	 * @param string uri which redirecting.
	 * @param string save the message in the session.
	 * @return object new ResponseRedirect.
	 */
	public function redirect($url, $message = ''){
		
		$session = Service::get('session');
		$session->returnURI = Service::get('request')->getURI();
		$session->set('message', $message);
		return new ResponseRedirect($url);
	}
	
	/**
	 * @param string name of route.
	 * @param array parameters of route.
	 * @return string route.
	 */
	public function generateRoute($name, $parameters = array()){
			
		return Service::get('router')->buildRoute($name, $parameters);
	}

}