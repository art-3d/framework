<?php

namespace Framework\Response;

class JsonResponse extends Response
{
	/**
	 * @var string type of response.
	 */
	
	public $type = 'json';
	
	
	/**
	 * @param string $content.
	 * @return void.
	 */
	public function __construct($content) 
	{ 
		$this->content = $content;
		$this->setHeader('HTTP/1.1 ' . $this->code . ' ' . $this->msg); 
		//$this->setHeader('Content-Type: application/json');
		header(implode("\n", $this->headers)); 
				
		echo json_encode($this->getContent()); 
	} 

}