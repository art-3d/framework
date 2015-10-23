<?php

namespace Framework\Validation;

class Validator {
	
	/**
	 * @var object model.
	 */
	protected $object;
	
	/**
	 * @var array.
	 */	
	protected $errors = array();
	
	/**
	 * @param $obj object model.
	 * @return void.
	 */
	public function __construct($obj){
		
		$this->object = $obj;
	}
	
	/**
	 * @return boolean.
	 */
	public function isValid(){
		
		$rules = $this->object->getRules();
		
		foreach($rules as $key => $val){
			foreach($val as $filter){
				
				if(!$filter->validate($this->object->$key)){
					$msg = $filter->getMessage();
					$this->errors[$key] = $msg;
					$error = true;
				}				
			}
		}
		return $error ? false : true;
	}
	
	/**
	 * @return array.
	 */
	public function getErrors(){
		return $this->errors;
	}
	
}