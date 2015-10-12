<?php

namespace Framework\Response;

use Framework\DI\Service;

class ResponseRedirect extends Response
{
	
	/**
	 * @var string type of response.
	 */
	public $type = 'redirect';
	
	/*
	 * @param string.
	 * @return void.
	 */
	public function __construct($url){
		
		// save some parameters ($_SESSION['message'])
			
		header('Location: ' . $url);
	}
	
}