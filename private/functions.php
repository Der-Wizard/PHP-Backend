<?php
function handlePostArgumentNotProvided(string $argument, string $errorMessage)
{
    if (!isset($_POST[$argument])) {
        echoWithError($errorMessage);
        exit;
    }
}
function handleGetArgumentNotProvided(string $argument, string $errorMessage)
{
    if (!isset($_GET[$argument])) {
        echoWithError($errorMessage);
        exit;
    }
}
function handleEmailInValid(string $email)
{
    if (empty($email)) {
        echoWithError('No email provided');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echoWithError('Invalid email format');
        exit;
    }
}
function echoWithSuccess($message)
{
    echoResponse('success', $message);
}
function echoWithError($message)
{
    echoResponse('error', $message);
}
function echoResponse($status, $message)
{
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
}
