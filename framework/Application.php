<?php

namespace Framework;	

use Framework\Router\Router;
use Framework\DI\Service;
use Framework\Request\Request;
use Framework\Renderer\Renderer;
use Framework\Exception\HttpNotFoundException;
use Framework\Session\Session;
use Framework\Security\Security;

class Application
{
	
	/**
	 * @var array configuration of application.
	 */
	public $config;
	
	/**
	 * @param array configuration of application.
	 * @return void.
	 */
	public function __construct($configPath){
		
		$this->config = include_once($configPath);
	}
	
	/**
	 * Initialization of application.
	 * @return void.
	 */
	public function run(){
		
		$router = new Router($this->config['routes']);
		
		$opt = array(
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		);
		$pdo_cfg = $this->config['pdo'];
		Service::set('pdo', new \PDO($pdo_cfg['dns'], $pdo_cfg['user'], $pdo_cfg['password'], $opt));		
		Service::set('application', $this);
		Service::set('router', $router);
		Service::set('request', new Request);
		Service::set('session', new Session);
		Service::set('security', new Security);
		
		try{			
			if($route = $router->find($_SERVER['REQUEST_URI'])){
				
					// check security
				if(isset($route['security'])){
					if(!Service::get('security')->isAuthenticated()){
						
					}
				}
			
				$controller = $route['controller'];
				$action = $route['action'] . 'Action';				
				$this->config['controller'] = $controller;
		
				$controllerReflection = new \ReflectionClass($controller);						
				if($controllerReflection->hasMethod($action)){
					$reflectionMethod = new \ReflectionMethod($controller, $action);
					
					$args = isset($route['parameters']) ? $route['parameters'] : array();
					$response = $reflectionMethod->invokeArgs(new $controller, $args);

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