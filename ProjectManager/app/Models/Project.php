<?php

declare(strict_types=1);

namespace App\Models;

class Project
{
    private ?int $id = null;

    private int $domainId = 0;

    private string $slug = '';

    private string $name = '';

    private ?string $description = null;

    private string $status = 'active';

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

        $this->domainId = isset($data['domain_id'])
            ? (int)$data['domain_id']
            : $this->domainId;

        $this->slug = trim(
            (string)($data['slug'] ?? $this->slug)
        );

        $this->name = trim(
            (string)($data['name'] ?? $this->name)
        );

        $this->description = array_key_exists('description', $data)
            ? ($data['description'] !== null
                ? trim((string)$data['description'])
                : null)
            : $this->description;

        $this->status = trim(
            (string)($data['status'] ?? $this->status)
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

    public function getDomainId(): int
    {
        return $this->domainId;
    }

    public function setDomainId(int $domainId): self
    {
        $this->domainId = $domainId;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = trim($slug);

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description !== null
            ? trim($description)
            : null;

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
            'domain_id' => $this->domainId,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}