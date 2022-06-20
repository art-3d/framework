<?php

namespace Framework\Validation\Filter;

abstract class Filter{
  /**
   * @var string.
   */
   protected $message;

  /**
   * @return string.
   */
  public function getMessage() {
	return $this->message ? $this->message : null;
  }
}