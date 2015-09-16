<?php

namespace Framework;	
	
class Application
{
	
	private $_config;
	
	public function __construct($config){
		$this->_config = $config;
	}
	
	public function run(){
		echo "It works";
	}
	
}