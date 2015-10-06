<?php

namespace Framework\Renderer;

use Framework\DI\Service;

class Renderer
{
	
	protected $view;
	protected $data = array();
	
	private $viewExtension = '.php';
	
	public function __construct($view, $data = array()){
		
		$this->view = $view;
		$this->data = $data;
	}
	
	public function render(){
		
		$app = Service::get('application');	
		
		$main_layout_path = $app->config['main_layout'];
		
		$controller = $app->config['controller'];
		
		$view_path = preg_replace('/Controller/', 'views', $controller, 1);
		$view_path = __DIR__ . '/../../src/' . str_replace('Controller', '', $viewPath) . '\\' . $this->view . $this->viewExtension;
		
		ob_start();		
		extract($this->data);		
		include($view_path);		
		return ob_get_clean();
	}
	
}