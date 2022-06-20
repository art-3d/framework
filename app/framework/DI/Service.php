<?php

namespace Framework\DI;

class Service
{
	/** object[] */
	private static array $objects = [];

	public static function set(string $name, object $object)
	{
		self::$objects[$name] = $object;
	}

	public static function get($name): ?object
	{
		return empty(self::$objects[$name]) ? null : self::$objects[$name];
	}

	private function __construct() {}
	private function __clone() {}
	// private function __sleep() {}
	// private function __wakeup() {}
}
