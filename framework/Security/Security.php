<?php

namespace Framework\Security;

use Framework\DI\Service;

class Security {	
	
	public function setUser($user)
	{		
		$session = Service::get('session');
		$session->set('user', $user);
	}
	
	public function clear()
	{		
		$session = Service::get('session');
		$session->destroy();
	}
	
	public function isAuthenticated()
	{		
		$session = Service::get('session');
		return $session->get('user') ? true : false;
	}
	
}