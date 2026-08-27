<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\ProjectMember;


class ProjectMemberRepository
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
            FROM project_members
            ORDER BY id ASC
            "
        );

        $members = [];

        foreach ($rows as $row) {
            $members[] = new ProjectMember($row);
        }

        return $members;
    }


    public function find(int $id): ?ProjectMember
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM project_members
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

        return new ProjectMember($rows[0]);
    }


    public function findByProject(int $projectId): array
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM project_members
            WHERE project_id = :project_id
            ORDER BY id ASC
            ",
            [
                'project_id' => $projectId
            ]
        );

        $members = [];

        foreach ($rows as $row) {
            $members[] = new ProjectMember($row);
        }

        return $members;
    }


    public function findByUser(int $userId): array
    {
        $rows = $this->database->query(
            "
            SELECT *
            FROM project_members
            WHERE user_id = :user_id
            ORDER BY id ASC
            ",
            [
                'user_id' => $userId
            ]
        );

        $members = [];

        foreach ($rows as $row) {
            $members[] = new ProjectMember($row);
        }

        return $members;
    }


    public function create(ProjectMember $member): int
    {
        $this->database->execute(
            "
            INSERT INTO project_members
            (
                project_id,
                user_id,
                role,
                created_at,
                updated_at
            )
            VALUES
            (
                :project_id,
                :user_id,
                :role,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP
            )
            ",
            [
                'project_id' => $member->getProjectId(),
                'user_id' => $member->getUserId(),
                'role' => $member->getRole()
            ]
        );

        return (int)$this->database->lastInsertId();
    }


    public function update(ProjectMember $member): bool
    {
        return $this->database->execute(
            "
            UPDATE project_members
            SET
                role = :role,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ",
            [
                'id' => $member->getId(),
                'role' => $member->getRole()
            ]
        );
    }


    public function delete(int $id): bool
    {
        return $this->database->execute(
            "
            DELETE FROM project_members
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
            FROM project_members
            "
        );

        return (int)$rows[0]['total'];
    }
}