<?php

namespace Framework\Security;

use Framework\DI\Service;

class Security {
	/**
	 * Save a user at the session.
	 * @param object $user.
	 * @return void.
	 */
	public function setUser($user)
	{
		$session = Service::get('session');
		$session->set('user', $user);
	}
	/**
	 * Delete session array.
	 * @return void.
	 */
	public function clear()
	{
		$session = Service::get('session');
		$session->destroy();
	}
	/**
	 * @return boolean.
	 */
	public function isAuthenticated()
	{
		$session = Service::get('session');

		return $session->get('user') ? true : false;
	}
}