<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

require('../private/functions.php');
require('../private/db_connect.php');
require('../private/jwt_auth.php');

use Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}


try {
    $credentials = getCredentials();
    $provided_user = getProvidedUserInformation($credentials);
    $conn = createConnection();
    handleUserLogin($conn, $provided_user);
} catch (Exception $e) {
    echoResponse("Unknown error occured. $e", '500');
    die("Some unknown error occured during processing!");
}

class UserInformation
{
    var $email;
    var $password;
    var $authentication_token;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}

function getCredentials() {
    $jsonData = file_get_contents('php://input');
    $credentials = json_decode($jsonData, true);
    return $credentials;
}

function getProvidedUserInformation($credentials)
{
    $email = htmlspecialchars(strip_tags($credentials['email']));
    $password = htmlspecialchars(strip_tags($credentials['password']));
    $user = new UserInformation($email, $password);
    return $user;
}
function handleUserLogin($conn, $user)
{
    $stmt = $conn->prepare("SELECT id, email, password FROM user WHERE email = ?");
    $stmt->bind_param('s', $user->email);
    if ($stmt->execute()) {
        $db_id = null;
        $db_email = '';
        $db_password = '';
        $stmt->bind_result($db_id, $db_email, $db_password);
        $stmt->fetch();
        if (password_verify($user->password, $db_password)) {
            $token = generate_jwt($db_id, $db_email);
            set_jwt_cookie($token);
            echoResponse('Login successful', '200');
            exit;
        } else {
            echoResponse("Invalid credentials", '401');
            exit;
        }
    } else {
        echoResponse('User not found', '404');
        exit;
    }
}

function generate_jwt($user_id, $user_email)
{
    $secret_key = $_ENV['JWT_SECRET'];
    $issuer_claim = 'localhost';
    $issued_at = time();
    $expiration_time = $issued_at + 3600;
    $payload = array(
        "iss" => $issuer_claim,
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "data" => array(
            "id" => $user_id,
            "email" => $user_email
        )
    );

    return JWT::encode($payload, $secret_key, 'HS256');
}

function set_jwt_cookie($jwt) {
    setcookie('jwt_token', $jwt, [
        'expires' => time() + 3600,
        'path' => '/',
        'domain' => 'localhost',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
}
