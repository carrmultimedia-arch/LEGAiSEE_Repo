<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\User;
use PDO;


class UserRepository
{
    private Database $database;


    public function __construct()
    {
        $this->database = new Database();
    }


    public function all(): array
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM users
            ORDER BY name ASC
            "
        );

        $users = [];

        foreach ($rows as $row) {
            $users[] = new User($row);
        }

        return $users;
    }


    public function find(int $id): ?User
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM users
            WHERE id = :id
            LIMIT 1
            ",
            [
                'id' => $id
            ]
        );

        if (empty($rows)) {
            return null;
        }

        return new User($rows[0]);
    }


    public function findByEmail(string $email): ?User
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
            ",
            [
                'email' => $email
            ]
        );

        if (empty($rows)) {
            return null;
        }

        return new User($rows[0]);
    }


    public function create(User $user): int
    {
        $this->database->execute(
            "
            INSERT INTO users
            (
                name,
                email,
                password_hash,
                active,
                created_at,
                updated_at
            )
            VALUES
            (
                :name,
                :email,
                :password_hash,
                :active,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
            ",
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password_hash' => $user->getPasswordHash(),
                'active' => $user->isActive()
                    ? 1
                    : 0
            ]
        );

        return (int)$this->database->lastInsertId();
    }


    public function update(User $user): bool
    {
        return $this->database->execute(
            "
            UPDATE users
            SET
                name = :name,
                email = :email,
                password_hash = :password_hash,
                active = :active,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ",
            [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password_hash' => $user->getPasswordHash(),
                'active' => $user->isActive()
                    ? 1
                    : 0
            ]
        );
    }


    public function delete(int $id): bool
    {
        return $this->database->execute(
            "
            DELETE FROM users
            WHERE id = :id
            ",
            [
                'id' => $id
            ]
        );
    }


    public function count(): int
    {
        $rows = $this->database->query(
            "
            SELECT COUNT(*) AS total
            FROM users
            "
        );

        return (int)$rows[0]['total'];
    }
}