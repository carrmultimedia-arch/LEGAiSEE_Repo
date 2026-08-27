<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Services\AuthorizationService;

class AuthController
{
    private UserRepository $users;

    private AuthorizationService $authorization;


    public function __construct(
        UserRepository $users,
        AuthorizationService $authorization
    ) {
        $this->users = $users;
        $this->authorization = $authorization;
    }


    public function login(array $request): array
    {
        if (
            empty($request['email']) ||
            empty($request['password'])
        ) {
            return [
                'success' => false,
                'message' => 'Email and password are required.'
            ];
        }

        $user = $this->users->findByEmail(
            trim($request['email'])
        );

        if ($user === null) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.'
            ];
        }

        if (
            !password_verify(
                $request['password'],
                $user->getPasswordHash()
            )
        ) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.'
            ];
        }

        if (!$user->isActive()) {
            return [
                'success' => false,
                'message' => 'Account disabled.'
            ];
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['user_id'] = $user->getId();

        return [
            'success' => true,
            'message' => 'Login successful.',
            'user' => $user->toArray()
        ];
    }


    public function logout(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        return [
            'success' => true,
            'message' => 'Logged out.'
        ];
    }


    public function status(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return [
            'authenticated' => isset($_SESSION['user_id']),
            'user_id' => $_SESSION['user_id'] ?? null
        ];
    }
}