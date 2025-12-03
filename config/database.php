<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','Password123!');
define('DB_NAME', 'fitness');

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if($conn->connect_error){
    die('Connection Feild' . $conn->connect_error);
}

?>

