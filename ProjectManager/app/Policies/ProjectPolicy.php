<?php

declare(strict_types=1);

namespace App\Policies;

class ProjectPolicy
{
    public function view(): string
    {
        return 'project.view';
    }

    public function create(): string
    {
        return 'project.create';
    }

    public function update(): string
    {
        return 'project.update';
    }

    public function delete(): string
    {
        return 'project.delete';
    }

    public function archive(): string
    {
        return 'project.archive';
    }

    public function manage(): string
    {
        return 'project.manage';
    }
}