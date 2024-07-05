<?php

namespace App\Middleware;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function handle()
    {
        if (!isset($_COOKIE['jwt'])) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $jwt = $_COOKIE['jwt'];
            JWT::decode($jwt, new Key($this->config['jwt_secret'], 'HS256'));
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }
    }
}