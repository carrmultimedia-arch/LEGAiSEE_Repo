<?php

declare(strict_types=1);

namespace App\Models;

class Permission
{
    private ?int $id = null;

    private string $name = '';

    private string $description = '';

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

        $this->description = trim(
            (string)($data['description'] ?? $this->description)
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


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }


    public function getDescription(): string
    {
        return $this->description;
    }


    public function setDescription(string $description): self
    {
        $this->description = trim($description);

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}