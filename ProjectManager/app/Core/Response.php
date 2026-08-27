<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    private mixed $content;

    private int $status;

    private array $headers = [];


    public function __construct(
        mixed $content = '',
        int $status = 200,
        array $headers = []
    ) {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }


    public function status(): int
    {
        return $this->status;
    }


    public function header(
        string $key,
        string $value
    ): self {

        $this->headers[$key] = $value;

        return $this;
    }


    public function json(
        array $data,
        int $status = 200
    ): self {

        $this->content = json_encode(
            $data,
            JSON_PRETTY_PRINT
        );

        $this->status = $status;

        $this->headers['Content-Type'] =
            'application/json';

        return $this;
    }


    public function send(): void
    {
        http_response_code($this->status);


        foreach ($this->headers as $key => $value) {

            header(
                $key . ': ' . $value
            );

        }


        echo $this->content;
    }


    public function getContent(): mixed
    {
        return $this->content;
    }
}