<?php

declare(strict_types=1);

namespace App\Repositories;

use App.Core\Database;

class ActivityLogRepository
{
    public function __construct(
        private Database $database
    ) {}

    public function create(array $data): bool
    {
        return $this->database->execute(
            "
            INSERT INTO activity_log
            (
                user_id,
                action,
                entity_type,
                entity_id,
                details
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?
            )
            ",
            [
                $data['user_id'] ?? null,
                $data['action'],
                $data['entity_type'],
                $data['entity_id'] ?? null,
                $data['details'] ?? null
            ]
        );
    }

    public function recent(int $limit = 50): array
    {
        return $this->database->query(
            "SELECT * FROM activity_log ORDER BY created_at DESC LIMIT {$limit}"
        );
    }
}