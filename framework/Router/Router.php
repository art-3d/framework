<?php
	
namespace Framework\Router;

class Router
{
	
	public static function find($uri, $routes){
		
		$parts = explode('/', $uri);
		array_shift($parts);
		/*
			DELETE NEXT LINE!!! (!documentroot)
		
		array_shift($parts);
		*/
		$controller = array_shift($parts);
		$action = array_shift($parts);
		
		foreach($routes as $key => $val){
			$patternParts = explode('/', $val['pattern']);
			$thisController = array_shift($patternParts);
			//$action = array_shift($patternParts);
			if($thisController == $controller){
				return $val;
			}
		}
		return false;		
	}
}