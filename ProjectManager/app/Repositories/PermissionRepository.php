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
        $rows = $this->database->query("
            SELECT *
            FROM projects
            ORDER BY name ASC
        ");

        $projects = [];

        foreach ($rows as $row) {
            $projects[] = new Project($row);
        }

        return $projects;
    }

    public function find(int $id): ?Project
    {
        $rows = $this->database->query("
            SELECT *
            FROM projects
            WHERE id = :id
            LIMIT 1
        ", [
            'id' => $id
        ]);

        if (!$rows) {
            return null;
        }

        return new Project($rows[0]);
    }

    public function findBySlug(string $slug): ?Project
    {
        $rows = $this->database->query("
            SELECT *
            FROM projects
            WHERE slug = :slug
            LIMIT 1
        ", [
            'slug' => $slug
        ]);

        if (!$rows) {
            return null;
        }

        return new Project($rows[0]);
    }

    public function create(Project $project): int
    {
        $this->database->execute("
            INSERT INTO projects
            (
                domain_id,
                slug,
                name,
                description,
                status,
                created_at,
                updated_at
            )
            VALUES
            (
                :domain_id,
                :slug,
                :name,
                :description,
                :status,
                NOW(),
                NOW()
            )
        ", [
            'domain_id'   => $project->getDomainId(),
            'slug'        => $project->getSlug(),
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
            'status'      => $project->getStatus()
        ]);

        return (int)$this->database->lastInsertId();
    }

    public function update(Project $project): bool
    {
        return $this->database->execute("
            UPDATE projects
            SET
                domain_id = :domain_id,
                slug = :slug,
                name = :name,
                description = :description,
                status = :status,
                updated_at = NOW()
            WHERE id = :id
        ", [
            'id'          => $project->getId(),
            'domain_id'   => $project->getDomainId(),
            'slug'        => $project->getSlug(),
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
            'status'      => $project->getStatus()
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->database->execute("
            DELETE FROM projects
            WHERE id = :id
        ", [
            'id' => $id
        ]);
    }

    public function count(): int
    {
        $rows = $this->database->query("
            SELECT COUNT(*) AS total
            FROM projects
        ");

        return (int)$rows[0]['total'];
    }
}