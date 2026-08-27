<?php

declare(strict_types=1);

namespace App\Models;

class Task
{
    private ?int $id = null;

    private int $projectId = 0;

    private string $title = '';

    private ?string $detail = null;

    private string $status = 'Backlog';

    private int $priority = 2;

    private ?string $dueDate = null;

    private ?string $blockedReason = null;

    private ?int $sourceIngestId = null;

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

        $this->title = trim(
            (string)($data['title'] ?? $this->title)
        );

        $this->detail = array_key_exists('detail', $data)
            ? ($data['detail'] !== null
                ? trim((string)$data['detail'])
                : null)
            : $this->detail;

        $this->status = trim(
            (string)($data['status'] ?? $this->status)
        );

        $this->priority = isset($data['priority'])
            ? (int)$data['priority']
            : $this->priority;

        $this->dueDate = $data['due_date']
            ?? $this->dueDate;

        $this->blockedReason = $data['blocked_reason']
            ?? $this->blockedReason;

        $this->sourceIngestId = isset($data['source_ingest_id'])
            ? (int)$data['source_ingest_id']
            : $this->sourceIngestId;

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

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = trim($title);
        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = trim($status);
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(?string $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getBlockedReason(): ?string
    {
        return $this->blockedReason;
    }

    public function setBlockedReason(?string $blockedReason): self
    {
        $this->blockedReason = $blockedReason;
        return $this;
    }

    public function getSourceIngestId(): ?int
    {
        return $this->sourceIngestId;
    }

    public function setSourceIngestId(?int $sourceIngestId): self
    {
        $this->sourceIngestId = $sourceIngestId;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->projectId,
            'title' => $this->title,
            'detail' => $this->detail,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->dueDate,
            'blocked_reason' => $this->blockedReason,
            'source_ingest_id' => $this->sourceIngestId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}