<?php

namespace Framework\Request;

use Framework\DI\Service;

class Request
{	
	
	public function __construct(){
		//...
	}
	
	public function getHost(){
		return $_SERVER['HTTP_HOST'];
	}
	
	public function getURI(){
		return $_SERVER['REQUEST_URI'];
	}
	
	public function getMethod(){
		return $_SERVER['REQUEST_METHOD'];
	}
	
	public function isPost(){
		return $this->getMethod($var) == 'POST';		
	}
	
	public function post($varname, $filterType = 'def'){
		return isset($_POST[$varname]) ? $this->filter($_POST[$varname], $filterType) : null;
	}
	
	public function get($varname, $filterType = 'def'){
		return isset($_GET[$varname]) ? $this->filter($_GET[$varname], $filterType) : null;
	}
	
	private function filter($var, $filterType = 'def'){
		
		switch($filterType){
			case 'int' : 
				
				break;
			default :
				$var = strip_tags($var);
				$var = htmlentities($var, ENT_QUOTES, "UTF-8");
				$var = htmlspecialchars($var, ENT_QUOTES);
				break;
		}
		
		return $var;
	}
	
}