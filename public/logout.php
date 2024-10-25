<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

require('../private/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    logOut();
} catch (Exception $e) {
    echoResponse("Unknown error occured. $e", '500');
    die("Some unknown error occured during processing!");
}

function logOut()
{
    echo $_COOKIE['jwt_token'];
    unset($_COOKIE['jwt_token']);
    setcookie('jwt_token', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    echoResponse('Logout successful', 200);
}
