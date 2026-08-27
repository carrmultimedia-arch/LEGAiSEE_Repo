<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App.Models\Task;


class TaskRepository
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
            FROM tasks
            ORDER BY position ASC, id ASC
            "
        );

        $tasks = [];

        foreach ($rows as $row) {
            $tasks[] = new Task($row);
        }

        return $tasks;
    }


    public function find(int $id): ?Task
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM tasks
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

        return new Task($rows[0]);
    }


    public function findByProject(int $projectId): array
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM tasks
            WHERE project_id = :project_id
            ORDER BY position ASC, id ASC
            ",
            [
                'project_id' => $projectId
            ]
        );

        $tasks = [];

        foreach ($rows as $row) {
            $tasks[] = new Task($row);
        }

        return $tasks;
    }


    public function create(Task $task): int
    {
        $this->database->execute(
            "
            INSERT INTO tasks
            (
                uuid,
                project_id,
                parent_task_id,
                title,
                description,
                status,
                priority,
                owner_id,
                assigned_to,
                position,
                start_date,
                due_date,
                completed_at,
                created_at,
                updated_at
            )
            VALUES
            (
                :uuid,
                :project_id,
                :parent_task_id,
                :title,
                :description,
                :status,
                :priority,
                :owner_id,
                :assigned_to,
                :position,
                :start_date,
                :due_date,
                :completed_at,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
            ",
            [
                'uuid' => $task->getUuid(),
                'project_id' => $task->getProjectId(),
                'parent_task_id' => $task->getParentTaskId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus(),
                'priority' => $task->getPriority(),
                'owner_id' => $task->getOwnerId(),
                'assigned_to' => $task->getAssignedTo(),
                'position' => $task->getPosition(),
                'start_date' => $task->getStartDate(),
                'due_date' => $task->getDueDate(),
                'completed_at' => $task->getCompletedAt()
            ]
        );

        return (int)$this->database->lastInsertId();
    }


    public function update(Task $task): bool
    {
        return $this->database->execute(
            "
            UPDATE tasks
            SET
                title = :title,
                description = :description,
                status = :status,
                priority = :priority,
                assigned_to = :assigned_to,
                position = :position,
                start_date = :start_date,
                due_date = :due_date,
                completed_at = :completed_at,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ",
            [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus(),
                'priority' => $task->getPriority(),
                'assigned_to' => $task->getAssignedTo(),
                'position' => $task->getPosition(),
                'start_date' => $task->getStartDate(),
                'due_date' => $task->getDueDate(),
                'completed_at' => $task->getCompletedAt()
            ]
        );
    }


    public function delete(int $id): bool
    {
        return $this->database->execute(
            "
            DELETE FROM tasks
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
            FROM tasks
            "
        );

        return (int)$rows[0]['total'];
    }
}