<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class AuthorizationService
{
    /**
     * Determine whether a user has a permission.
     */
    public function can(
        User $user,
        string $permission
    ): bool {
        foreach ($user->getRoles() as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Require permission or deny access.
     */
    public function authorize(
        User $user,
        string $permission
    ): void {
        if (!$this->can($user, $permission)) {
            throw new \RuntimeException(
                "Unauthorized action: {$permission}"
            );
        }
    }

    /**
     * Check multiple permissions.
     */
    public function canAny(
        User $user,
        array $permissions
    ): bool {
        foreach ($permissions as $permission) {
            if ($this->can($user, $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check that user has every permission.
     */
    public function canAll(
        User $user,
        array $permissions
    ): bool {
        foreach ($permissions as $permission) {
            if (!$this->can($user, $permission)) {
                return false;
            }
        }

        return true;
    }
}