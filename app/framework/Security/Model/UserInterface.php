<?php

namespace Framework\Security\Model;

interface UserInterface
{
	public function getTable(): string;

	public function getRole(): string;
}
