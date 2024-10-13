<?php

header("Access-Control-Allow-Origin: http://localhost:4200"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Allow-Headers: Content-Type"); 

require('../private/functions.php');
require('../private/db_connect.php');

try {
    $conn = createConnection();

} catch (Exception $e) {

}

?>