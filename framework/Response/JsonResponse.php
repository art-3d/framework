<?php

namespace Framework\Response;

class JsonResponse extends Response
{
	
	public $type = 'json';
	
	public function __construct() 
	{ 
		//$this->setHeader('HTTP/1.1 ' . $this->code . ' ' . $this->msg); 
		$this->setHeader('Content-Type: application/json'); 

		header(implode("\n", $this->headers)); 
		$this->content = json_encode($this->getContent()); 
	} 

}