<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

require('../private/jwt_auth.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

validate_jwt_cookie();

function validate_jwt_cookie()
{
    if (isset($_COOKIE['jwt_token'])) {
        $jwt = $_COOKIE['jwt_token'];

        try {
            $secret_key = $_ENV['JWT_SECRET'];
            $decoded = JWT::decode($jwt, new Key($secret_key,'HS256'));
            echo json_encode(['loggedIn' => true]);
        } 
        catch (Exception $e) {
            echo json_encode(['loggedIn' => false]);
        }
    } else {
        echo json_encode(['loggedIn' => false]);
    }
}
