<?php

declare(strict_types=1);

namespace Framework\DataBase;

class Connection
{
    private \PDO $pdo;

    public function __construct(
        string $pdoDsn,
        string $user,
        string $password,
        array $pdoParams,
    ) {
        $this->pdo = new \PDO($pdoDsn, $user, $password, $pdoParams);
    }

    public function pdo(): \PDO
    {
        return $this->pdo;
    }
}
