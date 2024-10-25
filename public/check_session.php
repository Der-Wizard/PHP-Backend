<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

require('../private/jwt_auth.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    validate_jwt_cookie();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['loggedIn' => false]);
}

function validate_jwt_cookie()
{
    if (isset($_COOKIE['jwt_token'])) {
        $jwt = $_COOKIE['jwt_token'];

        try {
            $secret_key = $_ENV['JWT_SECRET'];
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            http_response_code(200);
            echo json_encode(['loggedIn' => true]);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['loggedIn' => false]);
        }
    } else {
        echo json_encode(['loggedIn' => false]);
    }
}
