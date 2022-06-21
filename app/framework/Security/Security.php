<?php

namespace Framework\Security;

use Framework\DI\Service;
use Framework\Security\Model\UserInterface;

class Security {
	/**
	 * Save a user at the session.
	 */
	public function setUser(UserInterface $user): void
	{
		$session = Service::get('session');
		$session->set('user', $user);
	}
	/**
	 * Delete session array.
	 */
	public function clear(): void
	{
		$session = Service::get('session');
		$session->destroy();
	}
	/**
	 * @return boolean.
	 */
	public function isAuthenticated(): bool
	{
		$session = Service::get('session');

		return $session->get('user') ? true : false;
	}
}
