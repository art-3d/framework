<?php

namespace Framework\DI;

class Service
{
	
	/**
	 * @var array stored objects.
	 */
	private static $objects = array();
	
	/**
	 * Setter, store the object.
	 * @param string object name.
	 * @param object.
	 * @return void.
	 */
	public static function set($name, $object)
	{		
		self::$objects[$name] = $object;
	}
	
	/**
	 * Getter.
	 * @param string object name.
	 * @return object|null.
	 */
	public static function get($name)
	{		
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