<?php

namespace Framework\Response;

class Response implements ResponseInterface
{
	
	protected $content;
	protected $msg;
	protected $code;
	protected $headers = array();
	
	public function __construct($content, $msg = '', $code = 200){
		
		$this->content = $content;
		$this->msg = $msg;
		$thid->code = $code;
	}
	
	public function send(){
		
		$this->setHeader('HTTP/1.1 ' . $this->code . '' . $this->msg);
		headers(implode("\n", $this->headers));
		
		echo $this->getContent();
	}
	
	protected function getContent(){
		
		return $this->content;
	}
	
	protected function getCode(){
		
		return $this->code;
	}
	
	
	protected function setHeader($header){
		
		$this->headers[] = $header;
	}
	
}