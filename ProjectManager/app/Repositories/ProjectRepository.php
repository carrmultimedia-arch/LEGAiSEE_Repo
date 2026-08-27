<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Project;


class ProjectRepository
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
            FROM projects
            ORDER BY name ASC
            "
        );

        $projects = [];

        foreach ($rows as $row) {
            $projects[] = new Project($row);
        }

        return $projects;
    }


    public function find(int $id): ?Project
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM projects
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

        return new Project($rows[0]);
    }


    public function findByUuid(string $uuid): ?Project
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM projects
            WHERE uuid = :uuid
            LIMIT 1
            ",
            [
                'uuid' => $uuid
            ]
        );

        if (empty($rows)) {
            return null;
        }

        return new Project($rows[0]);
    }


    public function create(Project $project): int
    {
        $this->database->execute(
            "
            INSERT INTO projects
            (
                uuid,
                name,
                description,
                status,
                color,
                owner_id,
                start_date,
                due_date,
                created_at,
                updated_at
            )
            VALUES
            (
                :uuid,
                :name,
                :description,
                :status,
                :color,
                :owner_id,
                :start_date,
                :due_date,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
            ",
            [
                'uuid' => $project->getUuid(),
                'name' => $project->getName(),
                'description' => $project->getDescription(),
                'status' => $project->getStatus(),
                'color' => $project->getColor(),
                'owner_id' => $project->getOwnerId(),
                'start_date' => $project->getStartDate(),
                'due_date' => $project->getDueDate()
            ]
        );

        return (int)$this->database->lastInsertId();
    }


    public function update(Project $project): bool
    {
        return $this->database->execute(
            "
            UPDATE projects
            SET
                name = :name,
                description = :description,
                status = :status,
                color = :color,
                owner_id = :owner_id,
                start_date = :start_date,
                due_date = :due_date,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ",
            [
                'id' => $project->getId(),
                'name' => $project->getName(),
                'description' => $project->getDescription(),
                'status' => $project->getStatus(),
                'color' => $project->getColor(),
                'owner_id' => $project->getOwnerId(),
                'start_date' => $project->getStartDate(),
                'due_date' => $project->getDueDate()
            ]
        );
    }


    public function delete(int $id): bool
    {
        return $this->database->execute(
            "
            DELETE FROM projects
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
            FROM projects
            "
        );

        return (int)$rows[0]['total'];
    }
}