<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Role;


class RoleRepository
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
            FROM roles
            ORDER BY name ASC
            "
        );

        $roles = [];

        foreach ($rows as $row) {
            $roles[] = new Role($row);
        }

        return $roles;
    }


    public function find(int $id): ?Role
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM roles
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

        return new Role($rows[0]);
    }


    public function findByName(string $name): ?Role
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM roles
            WHERE name = :name
            LIMIT 1
            ",
            [
                'name' => $name
            ]
        );

        if (empty($rows)) {
            return null;
        }

        return new Role($rows[0]);
    }


    public function create(Role $role): int
    {
        $this->database->execute(
            "
            INSERT INTO roles
            (
                name,
                description,
                created_at,
                updated_at
            )
            VALUES
            (
                :name,
                :description,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
            ",
            [
                'name' => $role->getName(),
                'description' => $role->getDescription()
            ]
        );

        return (int)$this->database->lastInsertId();
    }


    public function update(Role $role): bool
    {
        return $this->database->execute(
            "
            UPDATE roles
            SET
                name = :name,
                description = :description,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ",
            [
                'id' => $role->getId(),
                'name' => $role->getName(),
                'description' => $role->getDescription()
            ]
        );
    }


    public function delete(int $id): bool
    {
        return $this->database->execute(
            "
            DELETE FROM roles
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
            FROM roles
            "
        );

        return (int)$rows[0]['total'];
    }
}