// public/index.php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$config = require __DIR__ . '/../src/config/config.php';

$authController = new AuthController($config);
$userController = new UserController();
$authMiddleware = new AuthMiddleware($config);

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login' && $method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $response = $authController->login($data['email'], $data['password']);
    echo json_encode($response);
} elseif ($uri === '/register' && $method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $response = $authController->register($data['email'], $data['password']);
    echo json_encode($response);
} elseif ($uri === '/profile' && $method === 'GET') {
    $authMiddleware->handle();
    $response = $userController->getProfile();
    echo json_encode($response);
} else {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Not Found']);
}