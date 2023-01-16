<?php

declare(strict_types=1);

namespace Framework\DI;

class Service
{
    /** object[] */
    private static array $objects = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function set(string $name, object $object)
    {
        self::$objects[$name] = $object;
    }

    public static function get($name): ?object
    {
        return empty(self::$objects[$name]) ? null : self::$objects[$name];
    }
}
