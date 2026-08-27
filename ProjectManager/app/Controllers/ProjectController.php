<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectController
{
    private ProjectRepository $projects;

    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
    }

    public function index(): array
    {
        $data = [];

        foreach ($this->projects->all() as $project) {
            $data[] = $project->toArray();
        }

        return [
            'success' => true,
            'count' => count($data),
            'data' => $data,
        ];
    }

    public function show(int $id): array
    {
        $project = $this->projects->find($id);

        if ($project === null) {
            return [
                'success' => false,
                'message' => 'Project not found.',
            ];
        }

        return [
            'success' => true,
            'data' => $project->toArray(),
        ];
    }

    public function store(array $data): array
    {
        $project = new Project();

        $project->setDomainId(
            isset($data['domain_id'])
                ? (int)$data['domain_id']
                : 1
        );

        $project->setSlug(
            trim((string)($data['slug'] ?? ''))
        );

        $project->setName(
            trim((string)($data['name'] ?? ''))
        );

        $project->setDescription(
            $data['description'] ?? null
        );

        $project->setStatus(
            (string)($data['status'] ?? 'active')
        );

        $id = $this->projects->create($project);

        return [
            'success' => true,
            'message' => 'Project created.',
            'id' => $id,
        ];
    }

    public function update(int $id, array $data): array
    {
        $project = $this->projects->find($id);

        if ($project === null) {
            return [
                'success' => false,
                'message' => 'Project not found.',
            ];
        }

        $project->fill($data);

        $this->projects->update($project);

        return [
            'success' => true,
            'message' => 'Project updated.',
        ];
    }

    public function destroy(int $id): array
    {
        if (!$this->projects->delete($id)) {
            return [
                'success' => false,
                'message' => 'Unable to delete project.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Project deleted.',
        ];
    }
}