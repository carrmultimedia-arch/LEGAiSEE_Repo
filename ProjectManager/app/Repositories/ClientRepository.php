<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Client;


class ClientRepository
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
            FROM clients
            ORDER BY name ASC
            "
        );

        $clients = [];

        foreach ($rows as $row) {
            $clients[] = new Client($row);
        }

        return $clients;
    }


    public function find(int $id): ?Client
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM clients
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

        return new Client($rows[0]);
    }


    public function create(Client $client): int
    {
        $this->database->execute(
            "
            INSERT INTO clients
            (
                name,
                company,
                email,
                phone,
                notes,
                owner_id,
                created_at,
                updated_at
            )
            VALUES
            (
                :name,
                :company,
                :email,
                :phone,
                :notes,
                :owner_id,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
            ",
            [
                'name' => $client->getName(),
                'company' => $client->getCompany(),
                'email' => $client->getEmail(),
                'phone' => $client->getPhone(),
                'notes' => $client->getNotes(),
                'owner_id' => $client->getOwnerId()
            ]
        );

        return (int)$this->database->lastInsertId();
    }


    public function update(Client $client): bool
    {
        return $this->database->execute(
            "
            UPDATE clients
            SET
                name = :name,
                company = :company,
                email = :email,
                phone = :phone,
                notes = :notes,
                owner_id = :owner_id,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ",
            [
                'id' => $client->getId(),
                'name' => $client->getName(),
                'company' => $client->getCompany(),
                'email' => $client->getEmail(),
                'phone' => $client->getPhone(),
                'notes' => $client->getNotes(),
                'owner_id' => $client->getOwnerId()
            ]
        );
    }


    public function delete(int $id): bool
    {
        return $this->database->execute(
            "
            DELETE FROM clients
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
            FROM clients
            "
        );

        return (int)$rows[0]['total'];
    }
}