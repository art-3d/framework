<?php

namespace Framework;	

use Framework\Router\Router;
use Framework\DI\Service;
use Framework\Request\Request;
use Framework\Renderer\Renderer;
use Framework\Exception\HttpNotFoundException;

class Application
{
	
	public $config;
	
	public function __construct($configPath){
		
		$this->config = include_once($configPath);
	}
	
	public function run(){
		
		$config = $this->config;
		
		$router = new Router($config['routes']);
		$request = new Request();
		
		Service::set('request', $request);
		Service::set('router', $router);
		Service::set('application', $this);
		
		try{			
			if($route = $router->find($_SERVER['REQUEST_URI'])){
			
				$controller = $route['controller'];
				$action = $route['action'] . 'Action';				
				$this->config['controller'] = $controller;
		
				$controllerReflection = new \ReflectionClass($controller);						
				if($controllerReflection->hasMethod($action)){
					$reflectionMethod = new \ReflectionMethod($controller, $action);
					
						if(!empty($route['parameters'])){
							$response = $reflectionMethod->invokeArgs(new $controller, $route['parameters']);
						}else{
							$response = $reflectionMethod->invoke(new $controller);
						}
						if(is_subclass_of($response, 'Framework\Response\ResponseInterface')){
							
							if($response->type == 'html'){
								
								$response->send();								
							}							
						}	
						
				}else{
					// The action is not found
					throw new HttpNotFoundException('Page Not Found!');
				}
			}else{
				// route is not found
				throw new HttpNotFoundException('Page Not Found!');
			}
		}catch( \Exception $e ){
			echo 'Exception is throw: <b>' . $e->getMessage() . '</b><br />';
		}
	}	
}