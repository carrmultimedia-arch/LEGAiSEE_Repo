<?php

declare(strict_types=1);

namespace App\Models;

class Comment
{
    private ?int $id = null;

    private int $taskId = 0;

    private int $userId = 0;

    private string $body = '';

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

        $this->taskId = isset($data['task_id'])
            ? (int)$data['task_id']
            : $this->taskId;

        $this->userId = isset($data['user_id'])
            ? (int)$data['user_id']
            : $this->userId;

        $this->body = trim(
            (string)($data['body'] ?? $this->body)
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


    public function getTaskId(): int
    {
        return $this->taskId;
    }


    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;

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


    public function getBody(): string
    {
        return $this->body;
    }


    public function setBody(string $body): self
    {
        $this->body = trim($body);

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'task_id' => $this->taskId,
            'user_id' => $this->userId,
            'body' => $this->body,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}