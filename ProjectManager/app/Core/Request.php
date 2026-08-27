<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private array $query;

    private array $body;

    private array $server;

    private array $files;


    public function __construct(
        array $query = [],
        array $body = [],
        array $server = [],
        array $files = []
    ) {
        $this->query = $query;
        $this->body = $body;
        $this->server = $server;
        $this->files = $files;
    }


    public static function capture(): self
    {
        return new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_FILES
        );
    }


    public function method(): string
    {
        return strtoupper(
            $this->server['REQUEST_METHOD'] ?? 'GET'
        );
    }


    public function uri(): string
    {
        return parse_url(
            $this->server['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        ) ?: '/';
    }


    public function input(
        string $key,
        mixed $default = null
    ): mixed {
        return $this->body[$key]
            ?? $this->query[$key]
            ?? $default;
    }


    public function all(): array
    {
        return array_merge(
            $this->query,
            $this->body
        );
    }


    public function json(): array
    {
        $content = file_get_contents('php://input');

        if (!$content) {
            return [];
        }

        $decoded = json_decode(
            $content,
            true
        );

        return is_array($decoded)
            ? $decoded
            : [];
    }
}