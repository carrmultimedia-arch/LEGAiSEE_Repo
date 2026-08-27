<?php

declare(strict_types=1);

namespace App\Models;

class Client
{
    private ?int $id = null;

    private string $name = '';

    private string $company = '';

    private string $email = '';

    private string $phone = '';

    private string $notes = '';

    private int $ownerId = 0;

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

        $this->company = trim(
            (string)($data['company'] ?? $this->company)
        );

        $this->email = trim(
            (string)($data['email'] ?? $this->email)
        );

        $this->phone = trim(
            (string)($data['phone'] ?? $this->phone)
        );

        $this->notes = trim(
            (string)($data['notes'] ?? $this->notes)
        );

        $this->ownerId = isset($data['owner_id'])
            ? (int)$data['owner_id']
            : $this->ownerId;

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


    public function getCompany(): string
    {
        return $this->company;
    }


    public function setCompany(string $company): self
    {
        $this->company = trim($company);

        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function setEmail(string $email): self
    {
        $this->email = trim($email);

        return $this;
    }


    public function getPhone(): string
    {
        return $this->phone;
    }


    public function setPhone(string $phone): self
    {
        $this->phone = trim($phone);

        return $this;
    }


    public function getNotes(): string
    {
        return $this->notes;
    }


    public function setNotes(string $notes): self
    {
        $this->notes = trim($notes);

        return $this;
    }


    public function getOwnerId(): int
    {
        return $this->ownerId;
    }


    public function setOwnerId(int $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company' => $this->company,
            'email' => $this->email,
            'phone' => $this->phone,
            'notes' => $this->notes,
            'owner_id' => $this->ownerId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}