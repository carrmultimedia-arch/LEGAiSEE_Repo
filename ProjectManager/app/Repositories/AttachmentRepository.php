<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

class AttachmentRepository
{
    public function __construct(
        private Database $database
    ) {}

    public function find(int $id): ?array
    {
        $result = $this->database->query(
            "SELECT * FROM attachments WHERE id = ?",
            [$id]
        );

        return $result[0] ?? null;
    }

    public function forEntity(
        string $type,
        int $id
    ): array {

        return $this->database->query(
            "SELECT * FROM attachments WHERE entity_type = ? AND entity_id = ?",
            [$type, $id]
        );
    }
}