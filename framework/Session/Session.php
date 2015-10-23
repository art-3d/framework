<?php

namespace Framework\Session;

class Session {
	
	/**
	 * @var string.
	 */
	public $returnUrl;
	
	/**
	 * @return void.
	 */
	public function __construct()
	{		
		session_start();
	}
	
	/**
	 * @param string $name.
	 * @param mixed $value.
	 * @return void.
	 */
	public function set($name, $value)
	{		
		$_SESSION[$name] = $value;
	}
	
	/**
	 * @param string $name.
	 * @return mixed.
	 */
	public function get($name)
	{		
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}
	
	/**
	 * @param string $name.
	 * @return void.
	 */
	public function delete($name)
	{		
		unset($_SESSION[$name]);
	}
	
	/**
	 * Delete session array.
	 * @return void.
	 */
	public function destroy()
	{	
		session_destroy();
	}
	
}