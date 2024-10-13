<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require('../private/functions.php');
require('../private/db_connect.php');

try {
    handleNoEmailProvided();

    $posted_email = $_POST['email'];

    handleEmailInvalid($posted_email);

    $conn = createConnection();

    handleAlreadySubscribed($conn, $posted_email);

    subscribeToNewsletter($conn, $posted_email);
} catch (Exception $e) {
    echoWithError("Unknown error occured.");
    die("Some unknown error occured during processing!");
}

function handleNoEmailProvided()
{
    handlePostArgumentNotProvided('email','No email provided');
}
function handleAlreadySubscribed($conn, $posted_email)
{
    $count = 0;

    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM newsletter_subscriber WHERE email = ?;");

    $email = $posted_email;
    $check_stmt->bind_param("s", $email);

    $check_stmt->execute();

    $check_stmt->bind_result($count);
    $check_stmt->fetch();

    $check_stmt->close();

    if (isset($count) && $count > 0) {
        echoWithSuccess('You are already subscribed!');
        $conn->close();
        die;
    }
}
function subscribeToNewsletter($conn, $posted_email)
{
    $stmt = $conn->prepare("INSERT INTO newsletter_subscriber VALUES (?);");

    $email = $posted_email;
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echoWithSuccess('Subscription successfully!');
    } else {
        echoWithError('Failed to subscribe.');
    }

    $stmt->close();
    $conn->close();
    die;
}
?>
