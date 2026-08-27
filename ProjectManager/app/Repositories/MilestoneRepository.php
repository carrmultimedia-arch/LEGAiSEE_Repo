<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Milestone;
use PDO;

class MilestoneRepository
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        $this->database = new Database();
        $this->connection = $this->database->connection();
    }

    public function all(): array
    {
        $rows = $this->database->query("
            SELECT *
            FROM milestones
            ORDER BY due_date ASC, created_at ASC
        ");

        $milestones = [];

        foreach ($rows as $row) {
            $milestones[] = $this->hydrate($row);
        }

        return $milestones;
    }

    public function byProject(int $projectId): array
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM milestones
            WHERE project_id = :project_id
            ORDER BY due_date ASC, created_at ASC
        ");

        $stmt->execute([
            'project_id' => $projectId
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $milestones = [];

        foreach ($rows as $row) {
            $milestones[] = $this->hydrate($row);
        }

        return $milestones;
    }

    public function find(int $id): ?Milestone
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM milestones
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function create(Milestone $milestone): int
    {
        $this->database->execute("
            INSERT INTO milestones
            (
                project_id,
                name,
                description,
                status,
                due_date,
                completed_at,
                created_at
            )
            VALUES
            (
                :project_id,
                :name,
                :description,
                :status,
                :due_date,
                :completed_at,
                :created_at
            )
        ", [
            'project_id'   => $milestone->getProjectId(),
            'name'         => $milestone->getName(),
            'description'  => $milestone->getDescription(),
            'status'       => $milestone->getStatus(),
            'due_date'     => $milestone->getDueDate(),
            'completed_at' => $milestone->getCompletedAt(),
            'created_at'   => $milestone->getCreatedAt()
        ]);

        return (int)$this->database->lastInsertId();
    }

    public function update(Milestone $milestone): bool
    {
        return $this->database->execute("
            UPDATE milestones
            SET
                name = :name,
                description = :description,
                status = :status,
                due_date = :due_date,
                completed_at = :completed_at
            WHERE id = :id
        ", [
            'id'           => $milestone->getId(),
            'name'         => $milestone->getName(),
            'description'  => $milestone->getDescription(),
            'status'       => $milestone->getStatus(),
            'due_date'     => $milestone->getDueDate(),
            'completed_at' => $milestone->getCompletedAt()
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->database->execute("
            DELETE FROM milestones
            WHERE id = :id
        ", [
            'id' => $id
        ]);
    }

    private function hydrate(array $row): Milestone
    {
        $milestone = new Milestone(
            (int)$row['project_id'],
            $row['name'],
            $row['description'] ?? ''
        );

        if (isset($row['id'])) {
            $milestone->setId((int)$row['id']);
        }

        if (isset($row['status'])) {
            $milestone->setStatus($row['status']);
        }

        if (array_key_exists('due_date', $row)) {
            $milestone->setDueDate($row['due_date']);
        }

        if (array_key_exists('completed_at', $row)) {
            $milestone->setCompletedAt($row['completed_at']);
        }

        if (isset($row['created_at'])) {
            $milestone->setCreatedAt($row['created_at']);
        }

        return $milestone;
    }
}