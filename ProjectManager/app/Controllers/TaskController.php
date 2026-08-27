<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App.Repositories\TaskRepository;


class TaskController
{
    private TaskRepository $tasks;


    public function __construct(
        TaskRepository $tasks
    ) {
        $this->tasks = $tasks;
    }


    public function index(): array
    {
        $tasks = $this->tasks->all();

        $response = [];

        foreach ($tasks as $task) {
            $response[] = $task->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }


    public function projectTasks(int $projectId): array
    {
        $tasks = $this->tasks->findByProject($projectId);

        $response = [];

        foreach ($tasks as $task) {
            $response[] = $task->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }


    public function show(int $id): array
    {
        $task = $this->tasks->find($id);

        if ($task === null) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        return [
            'success' => true,
            'data' => $task->toArray()
        ];
    }


    public function store(array $data): array
    {
        $task = new Task($data);

        $id = $this->tasks->create($task);

        return [
            'success' => true,
            'message' => 'Task created',
            'id' => $id
        ];
    }


    public function update(
        int $id,
        array $data
    ): array {

        $task = $this->tasks->find($id);

        if ($task === null) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }


        $task->fill($data);

        $this->tasks->update($task);


        return [
            'success' => true,
            'message' => 'Task updated'
        ];
    }


    public function destroy(int $id): array
    {
        $deleted = $this->tasks->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'Task deleted'
                : 'Unable to delete task'
        ];
    }
}