<?php

namespace Framework\Session;

class Session {
	
	public $returnUrl;
	
	public function __construct()
	{		
		session_start();
	}
	
	public function set($name, $value)
	{		
		$_SESSION[$name] = $value;
	}
	
	public function get($name)
	{		
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}
	
	public function delete($name)
	{		
		unset($_SESSION[$name]);
	}
	
		# delete all
	public function destroy()
	{	
		session_destroy();
	}
	
}