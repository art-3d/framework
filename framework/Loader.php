<?php
	
class Loader
{	
	
	protected static $_instance;
	
	private static $_namespacePath = array();
	
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
	
	public function load($className){
			// вырезает namespace (путь к файлу)
		$path = substr($className, 0, strrpos($className, "\\")+1); 
			// путь к файлу в нижний регистр
		$classPath = "..\\".str_replace(array($path, '\\'), array(strtolower($path), DIRECTORY_SEPARATOR), $className).".php";
				
		if(file_exists($classPath)){
			include $classPath;
		}else{
			//поиск в $namespacePath
			
		}		
	}
	
	public static function addNamespacePath($name, $path){
		self::$_namespacePath[$name] = $path;
	}

	
	private function __clone(){		
	}
	
	private function __sleep(){		
	}
	
	private function __wakeup(){
	}
}

	//init
Loader::getInstance();