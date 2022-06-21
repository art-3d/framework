<?php

namespace Framework\Validation\Filter;

interface FilterInterface
{
	public function isValid($entity);
	public function getMessage(): string;
}
