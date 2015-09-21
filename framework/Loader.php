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
		
		$loadStatus = false;
			// замена разделителей
		$classPath = '../' . lcfirst(str_replace('\\', '/', $className)) . '.php';
		if(file_exists($classPath)){
			include_once $classPath;
			$loadStatus = true;
		}else{
			// поиск в $namespacePath (проверка через рег. )
			foreach(self::$_namespacePath as $namespace => $path){
				$pattern = '/^'.$namespace.'\.{0,}$/';
				if(preg_match($pattern, $className)){
						// замена пространства имен на путь к файлу
					$classPath = str_replace($namespace, $path.'/', $className);
						// замена разделителей
					$classPath = str_replace('\\', '/', $classPath).'.php';
					if(file_exists($classPath)){
						include_once $classPath;
						$loadStatus = true;
						break;
					}
				}
			}
		}
		/*if(!$loadStatus){
			echo $classPath . ' не найден<br />';
		}*/
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