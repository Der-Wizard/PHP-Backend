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

    unsubscribeToNewsletter($conn, $posted_email);
    
} catch (Exception $e) {
    echoWithError("Unknown error occured.");
    die("Some unknown error occured during processing!");
}


function handleNoEmailProvided()
{
    handlePostArgumentNotProvided('email','No email provided');
}
function unsubscribeToNewsletter($conn, $posted_email)
{
    $stmt = $conn->prepare("DELETE FROM newsletter_subscriber WHERE email = ?");

    $email = $posted_email;
    $stmt->bind_param("s", $email);

    
    if ($stmt->execute()) {
        echoWithSuccess('Unsubscribed successfully!');
    } else {
        echoWithError('Failed to unsubscribe. Please reload and try again');
    }

    $stmt->close();
    $conn->close();
    die;
}

?>
