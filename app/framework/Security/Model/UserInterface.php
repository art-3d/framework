<?php

namespace Framework\Security\Model;

interface UserInterface
{
	public function getTable();

	public function getRole(): string;
}
