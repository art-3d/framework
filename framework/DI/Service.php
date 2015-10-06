<?php

namespace Framework\DI;

class Service
{
	
	protected static $_instance;
	
	private static $services = array();

	private function __construct(){
		
		spl_autoload_register(array($this, 'load'));
	}
	
	public static function getInstance(){
		
		if(null === self::$_instance){
			//create new instance
			self::$_instance = new self();
		}		
		return self::$_instance;
	}	
	
	public static function set($service_name, $object){
		
		self::$services[$service_name] = $object;
	}
	
	public static function get($service_name){
		
		return empty(self::$services[$service_name]) ? null : self::$services[$service_name];
	}
	
	private function __clone(){		
	}
	
	private function __sleep(){		
	}
	
	private function __wakeup(){
	}
	
}