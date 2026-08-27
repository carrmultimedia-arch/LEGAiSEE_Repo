<?php

declare(strict_types=1);

namespace App\Policies;

class UserPolicy
{
    public function view(): string
    {
        return 'user.view';
    }

    public function create(): string
    {
        return 'user.create';
    }

    public function update(): string
    {
        return 'user.update';
    }

    public function delete(): string
    {
        return 'user.delete';
    }

    public function manage(): string
    {
        return 'user.manage';
    }
}