<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Milestone;
use App\Repositories\MilestoneRepository;

class MilestoneController
{
    private MilestoneRepository $milestones;

    public function __construct(
        MilestoneRepository $milestones
    ) {
        $this->milestones = $milestones;
    }

    public function index(): array
    {
        $milestones = $this->milestones->all();

        $response = [];

        foreach ($milestones as $milestone) {
            $response[] = $milestone->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }

    public function show(int $id): array
    {
        $milestone = $this->milestones->find($id);

        if ($milestone === null) {
            return [
                'success' => false,
                'message' => 'Milestone not found'
            ];
        }

        return [
            'success' => true,
            'data' => $milestone->toArray()
        ];
    }

    public function store(array $data): array
    {
        $milestone = new Milestone($data);

        $id = $this->milestones->create($milestone);

        return [
            'success' => true,
            'message' => 'Milestone created',
            'id' => $id
        ];
    }

    public function update(
        int $id,
        array $data
    ): array {

        $milestone = $this->milestones->find($id);

        if ($milestone === null) {
            return [
                'success' => false,
                'message' => 'Milestone not found'
            ];
        }

        $milestone->fill($data);

        $this->milestones->update($milestone);

        return [
            'success' => true,
            'message' => 'Milestone updated'
        ];
    }

    public function destroy(int $id): array
    {
        $deleted = $this->milestones->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'Milestone deleted'
                : 'Unable to delete milestone'
        ];
    }
}