<?php

namespace Framework\Response;

class JsonResponse extends Response
{
	public string $type = 'json';

	public function __construct(string $content) 
	{ 
		$this->content = $content;
		$this->setHeader('HTTP/1.1 ' . $this->code . ' ' . $this->msg); 
		//$this->setHeader('Content-Type: application/json');
		header(implode("\n", $this->headers));
		echo json_encode($this->getContent()); 
	}
}