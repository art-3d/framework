<?php

namespace Framework\Validation\Filter;

class NotBlank implements FilterInterface {
  
  /**
   * @var string entity of validation.
   * @return boolean.
   */
  public function validate($entity){
	 
	return empty($entity) ? false : true;
  }
  
  
}