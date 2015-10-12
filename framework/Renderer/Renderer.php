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
	 * @param string.
	 * @param array.
	 * @return void.
	 */
	public function __construct($view, $parameters=array()){
		
		$this->view = $view;
		$this->parameters = $parameters;
	}
	
	/**
	 * @return string content of requested view.
	 */
	public function render(){
		
		$app = Service::get('application');	
		$route = Service::get('router');
		
		$getRoute = function($item, $param = array()) use (&$route) {
			
			return $route->buildRoute($item, $param);
			
		};
			# путь к главному шаблону
		$main_layout_path = $app->config['main_layout'];
			# текущий контроллер (нужен для определения view path)
		$controller = $app->config['controller'];
		
		$view_path = preg_replace('/Controller/', 'views', $controller, 1);
		$view_path = __DIR__ . '/../../src/' . str_replace('Controller', '', $view_path) . '\\' . $this->view . '.php';
		
		$view_path = str_replace('\\', '/', $view_path);
		
		$flush = array();
		
		$getRoute = function($item, $param = array()) use (&$route) {
			
			return $route->buildRoute($item, $param);			
		};
		
		$include = function($controller, $action, $params = array()){
			$action .= 'Action';
			$ctrl = new $controller;
			$refl = new \ReflectionMethod($ctrl, $action);
			$response = $refl->invokeArgs($ctrl, $params);			
			$response->send();
		};
		
		$generateToken = function(){
			return '';
		};
		
		ob_start();		
		extract($this->parameters);
		include($view_path);		
		$content = ob_get_clean();		
		
		ob_start();
		include($main_layout_path);
		return ob_get_clean();
	}
	
}