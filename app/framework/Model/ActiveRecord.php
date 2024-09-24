<?php

declare(strict_types=1);

namespace Framework\Model;

use Framework\DataBase\Connection;

abstract class ActiveRecord
{
    private \PDO $pdo;

    public function __construct(Connection $connection)
    {
        $this->pdo = $connection->pdo();
    }

    abstract public function getTable(): string;

    public function find(string|int $id): array|object|null
    {
        if ('all' === $id) {
            return $this->findAll();
        }

        $query = sprintf('SELECT * FROM %s WHERE id = %d', static::getTable(), $id);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function select(string $query, array $params = []): bool|object
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchObject();
    }

    public function query(string $query, array $params = []): void
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    public function save(): void
    {
        $names = [];
        $values = [];
        foreach (get_object_vars($this) as $name => $value) {
            if ('pdo' === $name) {
                continue;
            }

            $names[] = $name;
            $values[] = $value;
        }
        $names = '( '.implode(', ', $names).' )';
        $values = "( '".implode("', '", $values)."' )";
        $query = 'INSERT INTO `'.$this->getTable().'` '.$names.' VALUES '.$values;

        $result = $this->pdo->query($query);
    }

    public function findByEmail(string $email): bool|object
    {
        $query = 'SELECT * FROM `'.static::getTable().'` WHERE email = :email';

        return $this->select($query, ['email' => $email]);
    }

    /**
     * @return object[]
     */
    protected function findAll(): array
    {
        $query = 'SELECT * FROM `'.static::getTable().'`';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll($this->pdo::FETCH_CLASS);
    }
}
