<?php

namespace Framework\Model;

use Framework\DI\Service;

class ActiveRecord{

	/**
	 * @param int primary key of table.
	 * @return object row the found.
	 */
	public static function find($id){
		
		if($id == 'all'){
			return self::findAll();
		}
		else{
			$query = "SELECT * FROM `" . static::getTable() . "` WHERE `id`='$id'";
		}
		$pdo = Service::get('pdo');
		$stmt = $pdo->prepare($query);
		$stmt->execute();		
		return $stmt->fetchObject();
	}
	
	/**
	 * @return array of objects (all rows).
	 */
	protected static function findAll(){
		$pdo = Service::get('pdo');
		$query = "SELECT * FROM `" . static::getTable() . "`";
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll($pdo::FETCH_CLASS);
	}
	
	/**
	 * @param string query into database.
	 * @return object result of query.
	 */
	public static function select($query){
		$pdo = Service::get('pdo');
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchObject();
	}

	/**
	 * Save all public properties.
	 * @return void.
	 */
	public function save(){
		
		$reflect = new \ReflectionClass($this);
		$public_props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);		
		
		$props_name = array();
		$props_value = array();
		foreach($public_props as $prop){
			$props_name[] = $prop->getName();
			$props_value[] = $this->$props_name[count($props_name)-1];
		}
		
		$names = '( ' . implode(', ', $props_name) . ' )';
		$values = "( '" . implode("', '", $props_value) . "' )"; 
		
		$query = 'INSERT INTO `' . $this->getTable() . '` ' . $names . ' VALUES ' . $values;
		$result = Service::get('pdo')->query($query);		
	}

	
}
