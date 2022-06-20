<?php

namespace Framework\Response;

class ResponseRedirect extends Response
{
	public string $type = 'redirect';
	/*
	 * @param string $url.
	 * @return void.
	 */
	public function __construct($url)
	{
		header('Location: ' . $url);
	}
}