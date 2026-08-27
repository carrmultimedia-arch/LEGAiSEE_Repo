<?php

declare(strict_types=1);

namespace App\Models;

class ActivityLog
{
    public ?int $id = null;

    public ?int $user_id = null;

    public string $action;

    public string $entity_type;

    public ?int $entity_id = null;

    public ?string $details = null;

    public ?string $created_at = null;


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'action' => $this->action,
            'entity_type' => $this->entity_type,
            'entity_id' => $this->entity_id,
            'details' => $this->details,
            'created_at' => $this->created_at
        ];
    }
}