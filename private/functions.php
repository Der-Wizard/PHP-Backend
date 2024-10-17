<?php
function handlePostArgumentNotProvided(string $argument, string $errorMessage)
{
    if (!isset($_POST[$argument])) {
        echoResponse($errorMessage, '400');
        exit;
    }
}
function handleGetArgumentNotProvided(string $argument, string $errorMessage)
{
    if (!isset($_GET[$argument])) {
        echoResponse($errorMessage, '400');
        exit;
    }
}
function handleEmailInValid(string $email)
{
    if (empty($email)) {
        echoResponse('No email provided','400');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echoResponse('Invalid email format', '400');
        exit;
    }
}
function echoResponse($message, $response_code)
{
    http_response_code($response_code);
    echo json_encode([
        'code' => $response_code,
        'message' => $message
    ]);
}
