<?php

namespace Framework\Validation;

class Validator
{
	protected array $errors = [];

	public function __construct(protected object $obj) {
		$this->object = $obj;
	}

	public function isValid(): bool
	{
		$rules = $this->object->getRules();
		foreach($rules as $key => $val) {
			foreach($val as $filter) {
				if (!$filter->validate($this->object->$key)) {
					$msg = $filter->getMessage();
					$this->errors[$key] = $msg;
					$error = true;
				}
			}
		}

		return $error ? false : true;
	}

	public function getErrors(): array
	{
		return $this->errors;
	}
}