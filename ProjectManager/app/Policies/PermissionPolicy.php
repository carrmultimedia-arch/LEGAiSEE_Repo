<?php

declare(strict_types=1);

namespace App\Policies;

class PermissionPolicy
{
    public function view(): string
    {
        return 'permission.view';
    }

    public function assign(): string
    {
        return 'permission.assign';
    }

    public function manage(): string
    {
        return 'permission.manage';
    }
}