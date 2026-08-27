<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;


class UserController
{
    private UserRepository $users;


    public function __construct(
        UserRepository $users
    ) {
        $this->users = $users;
    }


    public function index(): array
    {
        $users = $this->users->all();

        $response = [];

        foreach ($users as $user) {
            $response[] = $user->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }


    public function show(int $id): array
    {
        $user = $this->users->find($id);

        if ($user === null) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        return [
            'success' => true,
            'data' => $user->toArray()
        ];
    }


    public function store(array $data): array
    {
        $user = new User($data);

        $id = $this->users->create($user);

        return [
            'success' => true,
            'message' => 'User created',
            'id' => $id
        ];
    }


    public function update(
        int $id,
        array $data
    ): array {

        $user = $this->users->find($id);

        if ($user === null) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }


        $user->fill($data);

        $this->users->update($user);


        return [
            'success' => true,
            'message' => 'User updated'
        ];
    }


    public function destroy(int $id): array
    {
        $deleted = $this->users->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'User deleted'
                : 'Unable to delete user'
        ];
    }
}