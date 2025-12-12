<?php

// define('DB_HOST','localhost');
// define('DB_USER','root');
// define('DB_PASS','Password123!');
// define('DB_NAME', 'fitness');

// $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);




$host = (!empty(getenv('DB_HOST'))) ? getenv('DB_HOST') : "localhost";
$user = (!empty(getenv('DB_USER'))) ? getenv('DB_USER') : "root";
$pass = (!empty(getenv('DB_PASSWORD'))) ? getenv('DB_PASSWORD') : "Password123!";
$db   = (!empty(getenv('DB_NAME'))) ? getenv('DB_NAME') : "fitness";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

