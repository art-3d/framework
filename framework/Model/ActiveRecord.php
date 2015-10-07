<?php

namespace Framework\Model;

use Framework\DI\Service;

abstract class ActiveRecord{

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
		return $stmt->fetch();
	}
	
	protected static function findAll(){
		$pdo = Service::get('pdo');
		$query = "SELECT * FROM `" . static::getTable() . "`";
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public static function query($query){
		$pdo = Service::get('pdo');
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

		
	/*
		Сохраняет все public свойства в таблицу
	*/
	public function save(){
		
		parent::init();
		
		$reflect = new ReflectionClass($this);
		$public_props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);		
		
		$props_name = array();
		$props_value = array();
		foreach($public_props as $prop){
			$props_name[] = $prop->getName();
			$props_value[] = $this->$props_name[count($props_name)-1];
		}
		
		$names = '( ' . implode(', ', $props_name) . ' )';
		$values = "( '" . implode("', '", $props_value) . "' )"; 
		
		$query = 'INSERT INTO `' . $this->getTable() . '` ' . $names . ' VALUES ' . $values;
		$stmt = self::$pdo->query($query);		
	}
	
}
