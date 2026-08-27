<?php

declare(strict_types=1);

namespace App\Policies;

class RolePolicy
{
    public function view(): string
    {
        return 'role.view';
    }

    public function create(): string
    {
        return 'role.create';
    }

    public function update(): string
    {
        return 'role.update';
    }

    public function delete(): string
    {
        return 'role.delete';
    }

    public function assign(): string
    {
        return 'role.assign';
    }
}