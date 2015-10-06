<?php

namespace Framework\Model;

abstract class ActiveRecord{

	/**
	 * @var DBO
	 */
	protected $db;

	/**
	 * @var Entity  DB Table name
	 */
	protected $table;

	/**
	 * @var string  Primary key column name
	 */
	protected $pk;

	/**
	 * Class constructor
	 */
	public function __construct($db, $table, $pk = 'id'){

		$this->db = $db;
		$this->table = $table;
		$this->pk = $pk;
	}

	/**
	 * Validate record data
	 *
	 * @return bool
	 */
	public function validate(){
		return true;
	}

	/**
	 * Bind data from source to current object
	 *
	 * @param $source
	 */
	protected function bind($source){

		//@TODO: Some implementation...
	}

	/**
	 * Find single record by pk (id)
	 *
	 * @param $id
	 */
	abstract public function find($id);

	/**
	 * Save current record to database
	 *
	 * @return mixed
	 */
	abstract public function save();

	/**
	 * Delete current record from db
	 */
	public function delete(){

		$this->db->query("DELETE FROM `".$this->db->escape_string($this->table)."` WHERE `".$this->db->escape_string($this->pk)."`=".(int)$this->$pk);
	}
}
