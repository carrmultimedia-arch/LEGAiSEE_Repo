<?php

declare(strict_types=1);

namespace App\Models;

class Label
{
    private ?int $id = null;

    private string $name = '';

    private string $color = '#2563eb';

    private ?int $projectId = null;

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

        $this->name = trim(
            (string)($data['name'] ?? $this->name)
        );

        $this->color = (string)(
            $data['color']
            ?? $this->color
        );

        $this->projectId = array_key_exists(
            'project_id',
            $data
        )
            ? (
                $data['project_id'] === null
                ? null
                : (int)$data['project_id']
            )
            : $this->projectId;

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


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }


    public function getColor(): string
    {
        return $this->color;
    }


    public function setColor(string $color): self
    {
        $this->color = trim($color);

        return $this;
    }


    public function getProjectId(): ?int
    {
        return $this->projectId;
    }


    public function setProjectId(?int $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'project_id' => $this->projectId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}