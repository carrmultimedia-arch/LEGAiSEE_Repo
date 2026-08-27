<?php

declare(strict_types=1);

namespace App\Models;

class ProjectMember
{
    private ?int $id = null;

    private int $projectId = 0;

    private int $userId = 0;

    private string $role = 'member';

    private string $createdAt = '';

    private string $updatedAt = '';


    public function __construct(array $data = [])
    {
        $this->fill($data);
    }


    public function fill(array $data): void
    {
        $this->id = isset($data['id'])
            ? (int)$data['id']
            : $this->id;

        $this->projectId = isset($data['project_id'])
            ? (int)$data['project_id']
            : $this->projectId;

        $this->userId = isset($data['user_id'])
            ? (int)$data['user_id']
            : $this->userId;

        $this->role = (string)(
            $data['role']
            ?? $this->role
        );

        $this->createdAt = (string)(
            $data['created_at']
            ?? $this->createdAt
        );

        $this->updatedAt = (string)(
            $data['updated_at']
            ?? $this->updatedAt
        );
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }


    public function getProjectId(): int
    {
        return $this->projectId;
    }


    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }


    public function getUserId(): int
    {
        return $this->userId;
    }


    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


    public function getRole(): string
    {
        return $this->role;
    }


    public function setRole(string $role): self
    {
        $this->role = trim($role);

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->projectId,
            'user_id' => $this->userId,
            'role' => $this->role,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}