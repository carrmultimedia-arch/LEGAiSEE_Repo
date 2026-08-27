<?php

declare(strict_types=1);

namespace App\Models;

class Attachment
{
    private ?int $id = null;

    private string $entityType = '';

    private int $entityId = 0;

    private string $filename = '';

    private string $storagePath = '';

    private ?string $mimeType = null;

    private ?int $fileSize = null;

    private ?int $uploadedBy = null;

    private string $createdAt = '';


    public function __construct(array $data = [])
    {
        $this->fill($data);
    }


    public function fill(array $data): void
    {
        $this->id = isset($data['id'])
            ? (int)$data['id']
            : $this->id;

        $this->entityType = trim(
            (string)(
                $data['entity_type']
                ?? $this->entityType
            )
        );

        $this->entityId = isset($data['entity_id'])
            ? (int)$data['entity_id']
            : $this->entityId;

        $this->filename = trim(
            (string)(
                $data['filename']
                ?? $this->filename
            )
        );

        $this->storagePath = trim(
            (string)(
                $data['storage_path']
                ?? $this->storagePath
            )
        );

        $this->mimeType = $data['mime_type']
            ?? $this->mimeType;

        $this->fileSize = isset($data['file_size'])
            ? (int)$data['file_size']
            : $this->fileSize;

        $this->uploadedBy = array_key_exists(
            'uploaded_by',
            $data
        )
            ? (
                $data['uploaded_by'] === null
                ? null
                : (int)$data['uploaded_by']
            )
            : $this->uploadedBy;

        $this->createdAt = (string)(
            $data['created_at']
            ?? $this->createdAt
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


    public function getEntityType(): string
    {
        return $this->entityType;
    }


    public function setEntityType(string $type): self
    {
        $this->entityType = trim($type);

        return $this;
    }


    public function getEntityId(): int
    {
        return $this->entityId;
    }


    public function setEntityId(int $id): self
    {
        $this->entityId = $id;

        return $this;
    }


    public function getFilename(): string
    {
        return $this->filename;
    }


    public function setFilename(string $filename): self
    {
        $this->filename = trim($filename);

        return $this;
    }


    public function getStoragePath(): string
    {
        return $this->storagePath;
    }


    public function setStoragePath(string $path): self
    {
        $this->storagePath = trim($path);

        return $this;
    }


    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }


    public function setMimeType(?string $mime): self
    {
        $this->mimeType = $mime;

        return $this;
    }


    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }


    public function setFileSize(?int $size): self
    {
        $this->fileSize = $size;

        return $this;
    }


    public function getUploadedBy(): ?int
    {
        return $this->uploadedBy;
    }


    public function setUploadedBy(?int $userId): self
    {
        $this->uploadedBy = $userId;

        return $this;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'entity_type' => $this->entityType,
            'entity_id' => $this->entityId,
            'filename' => $this->filename,
            'storage_path' => $this->storagePath,
            'mime_type' => $this->mimeType,
            'file_size' => $this->fileSize,
            'uploaded_by' => $this->uploadedBy,
            'created_at' => $this->createdAt,
        ];
    }
}