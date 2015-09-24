<?php

namespace Framework\Response;

class JsonResponse extends Response
{
	
	public function send() 
	{ 
		$this->setHeader('HTTP/1.1 ' . $this->code . ' ' . $this->msg); 
		$this->setHeader('Content-Type: application/json'); 

		headers(implode("\n", $this->headers)); 
		echo json_encode($this->getContent()); 
	} 

}