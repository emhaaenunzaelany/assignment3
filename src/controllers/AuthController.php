<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController
{
    private $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../config/config.php';
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::find($email);
        if ($user && password_verify($password, $user['password'])) {
            $token = JWT::encode(['email' => $email], $this->config['jwt_secret'], 'HS256');
            setcookie('jwt', $token, time() + (86400 * 30), "/"); // 86400 = 1 day
            echo json_encode(['status' => 'success', 'message' => 'Logged in successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
        }
    }

    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Handle user registration logic here
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    }
}