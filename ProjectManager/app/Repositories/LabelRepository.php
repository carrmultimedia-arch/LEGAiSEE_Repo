<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Label;
use PDO;

class LabelRepository
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
            FROM labels
            ORDER BY name ASC
        ");

        $labels = [];

        foreach ($rows as $row) {
            $label = new Label(
                $row['name'],
                $row['color'] ?? '#6B7280',
                isset($row['project_id']) ? (int)$row['project_id'] : null
            );

            if (isset($row['id'])) {
                $label->setId((int)$row['id']);
            }

            $labels[] = $label;
        }

        return $labels;
    }

    public function byProject(int $projectId): array
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM labels
            WHERE project_id = :project_id
            ORDER BY name ASC
        ");

        $stmt->execute([
            'project_id' => $projectId
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];

        foreach ($rows as $row) {
            $label = new Label(
                $row['name'],
                $row['color'] ?? '#6B7280',
                isset($row['project_id']) ? (int)$row['project_id'] : null
            );

            if (isset($row['id'])) {
                $label->setId((int)$row['id']);
            }

            $labels[] = $label;
        }

        return $labels;
    }

    public function find(int $id): ?Label
    {
        $stmt = $this->connection->prepare("
            SELECT *
            FROM labels
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

        $label = new Label(
            $row['name'],
            $row['color'] ?? '#6B7280',
            isset($row['project_id']) ? (int)$row['project_id'] : null
        );

        $label->setId((int)$row['id']);

        return $label;
    }

    public function create(Label $label): int
    {
        $this->database->execute("
            INSERT INTO labels
            (
                name,
                color,
                project_id
            )
            VALUES
            (
                :name,
                :color,
                :project_id
            )
        ", [
            'name' => $label->getName(),
            'color' => $label->getColor(),
            'project_id' => $label->getProjectId()
        ]);

        return (int)$this->database->lastInsertId();
    }

    public function update(Label $label): bool
    {
        return $this->database->execute("
            UPDATE labels
            SET
                name = :name,
                color = :color,
                project_id = :project_id
            WHERE id = :id
        ", [
            'id' => $label->getId(),
            'name' => $label->getName(),
            'color' => $label->getColor(),
            'project_id' => $label->getProjectId()
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->database->execute("
            DELETE FROM labels
            WHERE id = :id
        ", [
            'id' => $id
        ]);
    }
}