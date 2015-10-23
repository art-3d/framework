<?php

namespace Framework\Validation\Filter;

use Framework\Validation\Filter\Filter;

class Length extends Filter implements FilterInterface {
  
  /**
   * @var int.
   */
  protected $minLength;
  
  /**
   * @var int.
   */
  protected $maxLength;

  /**
   * @param int $min.
   * @param int $max.
   * @return void.
   */
  public function __construct($min, $max){
  
    $this->minLength = $min;
    $this->maxLength = $max;
  }
  
  /**
   * @param string $entity entity of validation.
   * @return boolean.
   */
  public function validate($entity){
	$strlen = strlen($entity);
	if($strlen < $this->minLength || $strlen > $this->maxLength){
		$this->message = 'Wrong length';
		return false;
	}
	return true;
  } 
  
}