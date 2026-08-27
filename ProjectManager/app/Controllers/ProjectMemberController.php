<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProjectMember;
use App\Repositories\ProjectMemberRepository;

class ProjectMemberController
{
    private ProjectMemberRepository $members;

    public function __construct(
        ProjectMemberRepository $members
    ) {
        $this->members = $members;
    }

    public function index(): array
    {
        $members = $this->members->all();

        $response = [];

        foreach ($members as $member) {
            $response[] = $member->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }

    public function projectMembers(int $projectId): array
    {
        $members = $this->members->findByProject($projectId);

        $response = [];

        foreach ($members as $member) {
            $response[] = $member->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }

    public function userProjects(int $userId): array
    {
        $members = $this->members->findByUser($userId);

        $response = [];

        foreach ($members as $member) {
            $response[] = $member->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }

    public function show(int $id): array
    {
        $member = $this->members->find($id);

        if ($member === null) {
            return [
                'success' => false,
                'message' => 'Project member not found'
            ];
        }

        return [
            'success' => true,
            'data' => $member->toArray()
        ];
    }

    public function store(array $data): array
    {
        $member = new ProjectMember($data);

        $id = $this->members->create($member);

        return [
            'success' => true,
            'message' => 'Project member added',
            'id' => $id
        ];
    }

    public function update(
        int $id,
        array $data
    ): array {

        $member = $this->members->find($id);

        if ($member === null) {
            return [
                'success' => false,
                'message' => 'Project member not found'
            ];
        }

        $member->fill($data);

        $this->members->update($member);

        return [
            'success' => true,
            'message' => 'Project member updated'
        ];
    }

    public function destroy(int $id): array
    {
        $deleted = $this->members->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'Project member removed'
                : 'Unable to remove project member'
        ];
    }
}