<?php

namespace Framework\Security;

use Framework\DI\Service;

class Security {	
	
	public function setUser($user){
		
		$session = Service::get('session');
		$session->set('auth_status', true);
		// save user props
		
	}
	
	public function clear(){
		
		$session = Service::get('session');
		$sesion->destroy();
	}
	
	public function isAuthenticated(){
		
		$session = Service::get('session');
		return $session->get('auth_status') ? true : false;
	}
	
}