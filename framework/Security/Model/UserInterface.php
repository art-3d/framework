<?php

namespace Framework\Security\Model;

interface UserInterface {
	
	public static function getTable();

	public function getRole();
}