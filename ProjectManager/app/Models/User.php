<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    private ?int $id = null;

    private string $name = '';

    private string $email = '';

    private string $passwordHash = '';

    private bool $active = true;

    private string $createdAt = '';

    private string $updatedAt = '';


   public function __construct(
    array|string $data = [],
    string $email = ''
) {
    if (is_array($data)) {

        $this->fill($data);

    } else {

        $this->name = trim($data);
        $this->email = trim($email);

    }
}


    public function fill(array $data): void
    {
        $this->id = isset($data['id'])
            ? (int)$data['id']
            : $this->id;

        $this->name = trim(
            (string)($data['name'] ?? $this->name)
        );

        $this->email = trim(
            (string)($data['email'] ?? $this->email)
        );

        $this->passwordHash = (string)(
            $data['password_hash']
            ?? $this->passwordHash
        );

        $this->active = isset($data['active'])
            ? (bool)$data['active']
            : $this->active;

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


    public function getEmail(): string
    {
        return $this->email;
    }


    public function setEmail(string $email): self
    {
        $this->email = trim($email);

        return $this;
    }


    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }


    public function setPasswordHash(string $hash): self
    {
        $this->passwordHash = $hash;

        return $this;
    }


    public function verifyPassword(string $password): bool
    {
        return password_verify(
            $password,
            $this->passwordHash
        );
    }


    public function isActive(): bool
    {
        return $this->active;
    }


    public function activate(): self
    {
        $this->active = true;

        return $this;
    }


    public function deactivate(): self
    {
        $this->active = false;

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'active' => $this->active,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}