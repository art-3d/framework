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
	 * @param string $url.
	 * @return void.
	 */
	public function __construct($url)
	{		
		header('Location: ' . $url);
	}
	
}