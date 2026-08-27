<?php

declare(strict_types=1);

namespace App\Policies;

class TaskPolicy
{
    public function view(): string
    {
        return 'task.view';
    }

    public function create(): string
    {
        return 'task.create';
    }

    public function update(): string
    {
        return 'task.update';
    }

    public function delete(): string
    {
        return 'task.delete';
    }

    public function assign(): string
    {
        return 'task.assign';
    }

    public function complete(): string
    {
        return 'task.complete';
    }
}