<?php

namespace Framework\Renderer;

use Framework\DI\Service;

class Renderer
{	
	/**
	 * @var string.
	 */
	protected $view;
	
	/**
	 * @var array parameters of the view.
	 */	
	protected $parameters;
	
	/**
	 * @param string $controller.
	 * @return string view path.
	 */
	protected function getView($controller){
		$view_path = preg_replace('/Controller/', 'views', $controller, 1);
		$view_path = __DIR__ . '/../../src/' . str_replace('Controller', '', $view_path) . '\\' . $this->view . '.php';
		$view_path = str_replace('\\', '/', $view_path);
		return $view_path;
	}
	
	/**
	 * @param string $view.
	 * @param array $parameters.
	 * @return string content of requested view.
	 */
	public function render($view, $parameters=array(), $absolute_path = false)
	{		
		$this->view = $view;
		$this->parameters = $parameters;
		
		$app = Service::get('application');
		$router = Service::get('router'); 
		
			# путь к главному шаблону
		$main_layout_path = $app->config['main_layout'];
		if(!$absolute_path){
				# путь к вызванному шаблону
			$view_path = $this->getView($app->config['controller']);					
		}else{
			$view_path = $view;
		}
			
			# Closures block ******************
		$getRoute = function($item, $param = array()) use (&$router) 
		{			
			return $router->buildRoute($item, $param);			
		};
		
		$include = function($controller, $action, $params = array())
		{
			$action .= 'Action';
			$ctrl = new $controller;
			$refl = new \ReflectionMethod($ctrl, $action);
			$response = $refl->invokeArgs($ctrl, $params);			
			$response->send();
		};
			
		$generateToken = function()
		{
			return '';
		};		
			# End closures block **************			
		
		$user = Service::get('session')->get('user'); // object
		
		$flush = array();//Service::get('session')->get('flush'); // array
		
		ob_start();		
		extract($this->parameters);
		include($view_path);		
		$content = ob_get_clean();		
		
		ob_start();
		include($main_layout_path);
		return ob_get_clean();
	}
	
}