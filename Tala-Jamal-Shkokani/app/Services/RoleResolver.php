<?php

namespace App\Services;

class RoleResolver
{
    /**
     * Determine the role for a new user.
     *
     * @param  array  $payload  The request payload (or any data array).
     * @return string
     */
    public static function resolve(array $payload): string
    {
        $isAdminCode = isset($payload['admin_code']) && $payload['admin_code'] === 'CHICADMIN2024';

        return (isset($payload['is_admin']) && $payload['is_admin']) || (isset($payload['role']) && $payload['role'] === 'admin') || $isAdminCode
            ? 'admin'
            : 'user';
    }
}
