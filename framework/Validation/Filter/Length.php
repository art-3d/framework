<?php

namespace Framework\Validation\Filter;

class Length implements FilterInterface {
  
  /**
   * @var int.
   */
  protected $minLength;
  
  /**
   * @var int.
   */
  protected $maxLength;

  /**
   * @param int.
   * @param int.
   * @return void.
   */
  public function __construct($min, $max){
  
    $this->minLength = $min;
    $this->maxLength = $max;
  }
  
  /**
   * @param string entity of validation.
   * @return boolean.
   */
  public function validate($entity){
	$strlen = strlen($entity);
	if($strlen < $this->minLength || $strlen > $this->maxLength){
		return false;
	}
	return true;
  }
  
  
}