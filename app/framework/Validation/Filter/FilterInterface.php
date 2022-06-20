<?php

namespace Framework\Validation\Filter;

interface FilterInterface
{
	public function validate($entity);
	public function getMessage();
}