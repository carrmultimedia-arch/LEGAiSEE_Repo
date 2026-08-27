<?php

declare(strict_types=1);

namespace App\Core;

use App\Database\Connection;
use PDO;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function connection(): PDO
    {
        return $this->connection;
    }

    public function query(string $sql, array $params = []): array
    {
        $statement = $this->connection->prepare($sql);

        $statement->execute($params);

        return $statement->fetchAll();
    }

    public function execute(string $sql, array $params = []): bool
    {
        $statement = $this->connection->prepare($sql);

        return $statement->execute($params);
    }

    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}