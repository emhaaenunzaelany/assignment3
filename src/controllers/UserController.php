<?php

namespace App\Controllers;

class UserController
{
    public function getProfile()
    {
        return ['status' => 'success', 'data' => ['email' => 'test@example.com']];
    }
}