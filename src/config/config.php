<?php
namespace App\Config;

require_once __DIR__ . '/../../vendor/autoload.php';



use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

return [
    'jwt_secret' => $_ENV['JWT_SECRET'],
];