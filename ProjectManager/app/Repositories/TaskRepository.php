<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;

class TaskRepository
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
            FROM pm_tasks
            ORDER BY project_id ASC, priority DESC, id ASC
        ");

        $tasks = [];

        foreach ($rows as $row) {
            $tasks[] = new Task($row);
        }

        return $tasks;
    }

    public function find(int $id): ?Task
    {
        $rows = $this->database->query("
            SELECT *
            FROM pm_tasks
            WHERE id = :id
            LIMIT 1
        ", [
            'id' => $id
        ]);

        if (empty($rows)) {
            return null;
        }

        return new Task($rows[0]);
    }

    public function findByProject(int $projectId): array
    {
        $rows = $this->database->query("
            SELECT *
            FROM pm_tasks
            WHERE project_id = :project_id
            ORDER BY priority DESC, id ASC
        ", [
            'project_id' => $projectId
        ]);

        $tasks = [];

        foreach ($rows as $row) {
            $tasks[] = new Task($row);
        }

        return $tasks;
    }

    public function create(Task $task): int
    {
        $this->database->execute("
            INSERT INTO pm_tasks
            (
                project_id,
                title,
                detail,
                status,
                priority,
                due_date,
                blocked_reason,
                source_ingest_id,
                created_at,
                updated_at
            )
            VALUES
            (
                :project_id,
                :title,
                :detail,
                :status,
                :priority,
                :due_date,
                :blocked_reason,
                :source_ingest_id,
                NOW(),
                NOW()
            )
        ", [
            'project_id'       => $task->getProjectId(),
            'title'            => $task->getTitle(),
            'detail'           => $task->getDetail(),
            'status'           => $task->getStatus(),
            'priority'         => $task->getPriority(),
            'due_date'         => $task->getDueDate(),
            'blocked_reason'   => $task->getBlockedReason(),
            'source_ingest_id' => $task->getSourceIngestId()
        ]);

        return (int)$this->database->lastInsertId();
    }

    public function update(Task $task): bool
    {
        return $this->database->execute("
            UPDATE pm_tasks
            SET
                project_id = :project_id,
                title = :title,
                detail = :detail,
                status = :status,
                priority = :priority,
                due_date = :due_date,
                blocked_reason = :blocked_reason,
                source_ingest_id = :source_ingest_id,
                updated_at = NOW()
            WHERE id = :id
        ", [
            'id'               => $task->getId(),
            'project_id'       => $task->getProjectId(),
            'title'            => $task->getTitle(),
            'detail'           => $task->getDetail(),
            'status'           => $task->getStatus(),
            'priority'         => $task->getPriority(),
            'due_date'         => $task->getDueDate(),
            'blocked_reason'   => $task->getBlockedReason(),
            'source_ingest_id' => $task->getSourceIngestId()
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->database->execute("
            DELETE FROM pm_tasks
            WHERE id = :id
        ", [
            'id' => $id
        ]);
    }

    public function count(): int
    {
        $rows = $this->database->query("
            SELECT COUNT(*) AS total
            FROM pm_tasks
        ");

        return (int)$rows[0]['total'];
    }
}