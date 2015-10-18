<?php

namespace Framework\Response;

class Response implements ResponseInterface
{	

	/**
	 * @var string type of response.
	 */
	public $type = 'html';
	
	/**
	 * @var string.
	 */
	protected $content;
	
	/**
	 * @var string message of header.
	 */
	protected $msg;
	
	/**
	 * @var int code of header.
	 */
	protected $code;
	
	/**
	 * @var array.
	 */		 
	protected $headers = array();
	
	/**
	 * @param string $content content of response.
	 * @param string $msg messaeg of header.
	 * @param int $code code of header.
	 * @return void.
	 */
	public function __construct($content, $msg = '', $code = 200)
	{		
		$this->content = $content;
		$this->msg = $msg;
		$this->code = $code;
	}
	
	/**
	 * Sending the response.
	 * @return void.
	 */
	public function send()
	{		
		$this->setHeader('HTTP/1.1 ' . $this->code . ' ' . $this->msg);
		header(implode("\n", $this->headers));
		
		echo $this->getContent();
	}
	
	/**
	 * @return string content.
	 */
	public function getContent()
	{		
		return $this->content;
	}
	
	/**
	 * @return int code of header.
	 */
	public function getCode()
	{		
		return $this->code;
	}
	
	/**
	 * @return void.
	 */	
	public function setHeader($header)
	{		
		$this->headers[] = $header;
	}
	
}