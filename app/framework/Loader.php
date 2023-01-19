<?php

declare(strict_types=1);

class Loader
{	
	protected static $_instance;
	private static $_namespacePath = [];

	private function __construct()
	{
		spl_autoload_register([$this, 'load']);
	}

	public static function getInstance(): self
	{
		if (null === self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function load(string $className): void
	{
		$loadStatus = false;
		$classPath = _ROOT . '/' . lcfirst(str_replace('\\', '/', $className)) . '.php';
		if (file_exists($classPath)) {
			include_once $classPath;
			$loadStatus = true;
		} else {
			foreach (self::$_namespacePath as $namespace => $path) {
				$pattern = '/^' . $namespace.'\.{0,}$/';
				if (preg_match($pattern, $className)) {
					$classPath = str_replace($namespace, $path . '/', $className);
					$classPath = str_replace('\\', '/', $classPath) . '.php';
					if (file_exists($classPath)) {
						include_once $classPath;
						$loadStatus = true;
						break;
					}
				}
			}
		}

		if (!$loadStatus) {
			throw new Exception(sprintf('Class \'%s\' not found in %s', $className, $classPath));
		}
	}

	public static function addNamespacePath(string $name, string $path): void
	{
		self::$_namespacePath[$name] = $path;
	}

	private function __clone() {}
}

Loader::getInstance();
