<?php

namespace Framework\DI;

class Service
{
	
	private static $objects = array();
	
	public static function set($name, $object){
		
		self::$objects[$name] = $object;
	}
	
	public static function get($name){
		
		return empty(self::$objects[$name]) ? null : self::$objects[$name];
	}
	
	private function __construct(){		
	}
	
	private function __clone(){		
	}
	
	private function __sleep(){		
	}
	
	private function __wakeup(){
	}
	
}