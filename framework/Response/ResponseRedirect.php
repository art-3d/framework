<?php

namespace Framework\Response;

use Framework\DI\Service;

class ResponseRedirect extends Response
{
	
	public $type = 'redirect';
	
	public function __construct($url){
		
		//$router = Service::get('router');
		//$location = 'http://' . $_SERVER['SERVER_NAME'] . $url;
		// save some parameters
			
		header('Location: ' . $url);
	}
	
}