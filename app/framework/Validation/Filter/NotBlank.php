<?php

namespace Framework\Validation\Filter;

use Framework\Validation\Filter\Filter;

class NotBlank extends Filter implements FilterInterface {
  /**
   * @param string $entity entity of validation.
   * @return boolean.
   */
  public function validate($entity) {
	$this->message = 'Blank value';

	return empty($entity) ? false : true;
  }
}