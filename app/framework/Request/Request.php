<?php

namespace Framework\Request;

use Framework\DI\Service;

class Request
{	
	/**
	 * @return string.
	 */
	public function getHost()
	{
		return $_SERVER['HTTP_HOST'];
	}
	/**
	 * @return string.
	 */	
	public function getURI()
	{
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * @return string.
	 */
	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * @return boolean.
	 */
	public function isPost()
	{
		return $this->getMethod() === 'POST';
	}

	/**
	 * Getter, from $_POST.
	 * @param string $varname.
	 * @return string.
	 */
	public function post($varname)
	{
		return isset($_POST[$varname]) ? $this->filter($_POST[$varname]) : null;
	}
	/**
	 * Getter, from $_GET.
	 * @param string $varname.
	 * @return string.
	 */
	public function get($varname)
	{
		return isset($_GET[$varname]) ? $this->filter($_GET[$varname]) : null;
	}
	/**
	 * @param string $var.
	 * @return string.
	 */
	private function filter($var)
	{
		$var = trim($var);
		$var = strip_tags($var);
		$var = htmlentities($var, ENT_QUOTES, "UTF-8");
		$var = htmlspecialchars($var, ENT_QUOTES);

		return $var;
	}
}