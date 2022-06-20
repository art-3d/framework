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

	public static function getInstance()
	{
		if (null === self::$_instance) {
			//create new instance
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    /**
     * @param string $className callable class name.
     */	
	public function load($className)
	{
		$loadStatus = false;
			// замена разделителей
		$classPath = '../' . lcfirst(str_replace('\\', '/', $className)) . '.php';
		if (file_exists($classPath)) {
			include_once $classPath;
			$loadStatus = true;
		} else {
			// поиск в $namespacePath (проверка через рег. )
			foreach(self::$_namespacePath as $namespace => $path) {
				$pattern = '/^' . $namespace.'\.{0,}$/';
				if (preg_match($pattern, $className)) {
						// замена пространства имен на путь к файлу
					$classPath = str_replace($namespace, $path.'/', $className);
						// замена разделителей
					$classPath = str_replace('\\', '/', $classPath) . '.php';
					if (file_exists($classPath)) {
						include_once $classPath;
						$loadStatus = true;
						break;
					}
				}
			}
		}
		/*if (!$loadStatus) {
			echo $classPath . ' не найден<br />';
		}*/
	}
    /**
	 * Saves paths to a namespace in array of this class.
     * @param string $name the beginning of class name.
     * @param string $path path to the file.
     */
	public static function addNamespacePath($name, $path)
	{
		self::$_namespacePath[$name] = $path;
	}
	private function __clone() {}
}

Loader::getInstance();
