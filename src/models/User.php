<?php

namespace App\Models;

class User
{
    public static function find($email)
    {
        $users = [
            'test@example.com' => [
                'email' => 'test@example.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
            ],
        ];

        return $users[$email] ?? null;
    }
}