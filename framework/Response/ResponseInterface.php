<?php

namespace Framework\ResponseInterface
{
	function setHeader($header);
	
	function getContent();
	
	function getCode();
	
	function send();
}