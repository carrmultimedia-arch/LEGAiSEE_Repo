<?php

declare(strict_types=1);

namespace App\Policies;

class DocumentPolicy
{
    public function view(): string
    {
        return 'document.view';
    }

    public function create(): string
    {
        return 'document.create';
    }

    public function update(): string
    {
        return 'document.update';
    }

    public function delete(): string
    {
        return 'document.delete';
    }

    public function download(): string
    {
        return 'document.download';
    }
}