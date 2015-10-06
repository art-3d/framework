<?php

namespace Framework\Response;

interface ResponseInterface
{
	function setHeader($header);
	
	function getContent();
	
	function getCode();
	
	function send();
}