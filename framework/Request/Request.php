<?php

namespace Framework\Request;

use Framework\DI\Service;

class Request
{	
	
	public function __construct(){
		//...
	}
	
	/**
	 * @return string.
	 */
	public function getHost(){
		return $_SERVER['HTTP_HOST'];
	}	
	
	/**
	 * @return string.
	 */	
	public function getURI(){
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * @return string.
	 */		
	public function getMethod(){
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * @return boolean.
	 */		
	public function isPost(){
		return $this->getMethod($var) == 'POST';		
	}

	/**
	 * Getter, from $_POST.
	 * @param string.
	 * @param string.
	 * @return string.
	 */		
	public function post($varname, $filterType = 'def'){
		return isset($_POST[$varname]) ? $this->filter($_POST[$varname], $filterType) : null;
	}
	
	/**
	 * Getter, from $_GET.
	 * @param string.
	 * @param string.
	 * @return string.
	 */
	public function get($varname, $filterType = 'def'){
		return isset($_GET[$varname]) ? $this->filter($_GET[$varname], $filterType) : null;
	}
	
	/**
	 * @param string.
	 * @param string.
	 * @return string.
	 */
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