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
		
		$router = new Router($this->config['routes']);
		
		$opt = array(
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		);	
		Service::set('pdo', new \PDO($this->config['pdo']['dns'], $this->config['pdo']['user'], $this->['pdo']['password'], $opt));		
		Service::set('application', $this);
		Service::set('router', $router);
		Service::set('request', new Request);
		
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