<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Label;
use App\Repositories\LabelRepository;

class LabelController
{
    private LabelRepository $labels;

    public function __construct(
        LabelRepository $labels
    ) {
        $this->labels = $labels;
    }

    public function index(): array
    {
        $labels = $this->labels->all();

        $response = [];

        foreach ($labels as $label) {
            $response[] = $label->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }

    public function show(int $id): array
    {
        $label = $this->labels->find($id);

        if ($label === null) {
            return [
                'success' => false,
                'message' => 'Label not found'
            ];
        }

        return [
            'success' => true,
            'data' => $label->toArray()
        ];
    }

    public function store(array $data): array
    {
        $label = new Label($data);

        $id = $this->labels->create($label);

        return [
            'success' => true,
            'message' => 'Label created',
            'id' => $id
        ];
    }

    public function update(
        int $id,
        array $data
    ): array {

        $label = $this->labels->find($id);

        if ($label === null) {
            return [
                'success' => false,
                'message' => 'Label not found'
            ];
        }

        $label->fill($data);

        $this->labels->update($label);

        return [
            'success' => true,
            'message' => 'Label updated'
        ];
    }

    public function destroy(int $id): array
    {
        $deleted = $this->labels->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'Label deleted'
                : 'Unable to delete label'
        ];
    }
}