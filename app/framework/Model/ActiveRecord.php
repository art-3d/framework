<?php

namespace Framework\Model;

use Framework\DI\Service;

abstract class ActiveRecord
{
	abstract public static function getTable(): string;

	public static function find(string|int $id): array|object|null
	{
		if ($id === 'all') {
			return self::findAll();
		}

		$query = "SELECT * FROM `" . static::getTable() . "` WHERE `id`='$id'";
		$pdo = Service::get('pdo');
		$stmt = $pdo->prepare($query);
		$stmt->execute();

		return $stmt->fetchObject();
	}

	/**
	 * @return array of objects (all rows).
	 */
	protected static function findAll(): array
	{
		$pdo = Service::get('pdo');
		$query = "SELECT * FROM `" . static::getTable() . "`";
		$stmt = $pdo->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll($pdo::FETCH_CLASS);
	}
	/**
	 * @param string $query query into database.
	 * @return object result of query.
	 */
	public static function select($query)
	{
		$pdo = Service::get('pdo');
		$stmt = $pdo->prepare($query);
		$stmt->execute();

		return $stmt->fetchObject();
	}
	/**
	 * @param string $query query into database.
	 */
	public static function query($query): void
	{
		$pdo = Service::get('pdo');
		$stmt = $pdo->prepare($query);
		$stmt->execute();
	}
	/**
	 * Save all public properties.
	 * @return void.
	 */
	public function save()
	{
		$names = [];
		$values = [];
		foreach (get_object_vars($this) as $name => $value) {
			$names[] = $name;
			$values[] = $value;
		}
		$names = '( ' . implode(', ', $names) . ' )';
		$values = "( '" . implode("', '", $values) . "' )";
		$query = 'INSERT INTO `' . $this->getTable() . '` ' . $names . ' VALUES ' . $values;

		$result = Service::get('pdo')->query($query);
	}
	/**
	 * @param string $email.
	 * @return object.
	 */
	public static function findByEmail(string $email)
	{
		$query = 'SELECT * FROM `' . static::getTable() . '`';

		return self::select($query);
	}	
}
