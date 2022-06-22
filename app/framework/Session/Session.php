<?php

namespace Framework\Session;

class Session
{
	public string $returnUrl;

	public function __construct()
	{
		session_start();
	}

	/**
	 * @param mixed $value
	 */
	public function set(string $name, string $value): void
	{
		$_SESSION[$name] = $value;
	}
	/**
	 * @return mixed.
	 */
	public function get(string $name)
	{
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	public function getUser(): ?object
	{
		$user = $this->get('user');

		return $user ? json_decode((string)$user) : null;
	}

	public function delete(string $name): void
	{
		unset($_SESSION[$name]);
	}

	public function destroy(): void
	{	
		session_destroy();
	}
}
