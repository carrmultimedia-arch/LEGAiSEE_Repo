<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Comment;
use App\Repositories\CommentRepository;


class CommentController
{
    private CommentRepository $comments;


    public function __construct(
        CommentRepository $comments
    ) {
        $this->comments = $comments;
    }


    public function index(): array
    {
        $comments = $this->comments->all();

        $response = [];

        foreach ($comments as $comment) {
            $response[] = $comment->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }


    public function taskComments(int $taskId): array
    {
        $comments = $this->comments->findByTask($taskId);

        $response = [];

        foreach ($comments as $comment) {
            $response[] = $comment->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }


    public function show(int $id): array
    {
        $comment = $this->comments->find($id);

        if ($comment === null) {
            return [
                'success' => false,
                'message' => 'Comment not found'
            ];
        }

        return [
            'success' => true,
            'data' => $comment->toArray()
        ];
    }


    public function store(array $data): array
    {
        $comment = new Comment($data);

        $id = $this->comments->create($comment);

        return [
            'success' => true,
            'message' => 'Comment created',
            'id' => $id
        ];
    }


    public function update(
        int $id,
        array $data
    ): array {

        $comment = $this->comments->find($id);

        if ($comment === null) {
            return [
                'success' => false,
                'message' => 'Comment not found'
            ];
        }


        $comment->fill($data);

        $this->comments->update($comment);


        return [
            'success' => true,
            'message' => 'Comment updated'
        ];
    }


    public function destroy(int $id): array
    {
        $deleted = $this->comments->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'Comment deleted'
                : 'Unable to delete comment'
        ];
    }
}