<?php
function createConnection()
{
    $host = "127.0.0.1";
    $username = "root";
    $password = "Saw0UsFw72LanVrCJri19KBuGBW3Up6Hgt9CYtVjOOjqkeUdvY";
    $database = "rest_api_demo";

    $conn = new mysqli($host, $username, $password, $database, 3006);

    if ($conn->connect_error) {
        echoResponse('Connection failed: ' . $conn->connect_error,'500');
        die;
    }
    return $conn;
}
?>