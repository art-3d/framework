<?php
	
namespace Framework\Controller;

use Framework\Response\ResponseRedirect;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\DI\Service;

abstract class Controller
{	
	
	public static function render($view, $params = array()){

		$renderer = new Renderer($view, $params);
		return new Response($renderer->render());
	}	
	
	public function getRequest(){
			
		return Service::get('request');
	}

	public function redirect($url, $message = ''){
		
		// session_start();
		// $_SESSION['message'] = $message;		
		
		return new ResponseRedirect($url); // ??
	}
	
	public function generateRoute($name, $parameters = array()){
		
		$route = Service::get('router');		
		return $route->buildRoute($name, $parameters);
	}	
}