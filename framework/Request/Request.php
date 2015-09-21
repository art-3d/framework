<?php

namespace Framework\Request;

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
	
	public function isPost($var){
		return $this->getMethod($var) == 'POST';
	}
	
	public function post($varname, $filterType = 'def'){
		return isset($_POST[$varname]) ? $this->filter($_POST[$varname], $filterType) : null;
	}
	
	public function get($varname, $filterType = 'def'){
		return isset($_GET[$varname]) ? $this->filter($_GET[$varname], $filterType) : null;
	}
	
	private function filter($varname, $filterType = 'def'){
		// TODO
	}
	
}