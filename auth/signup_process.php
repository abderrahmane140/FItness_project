<?php
session_start();
require __DIR__ .'/../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($check) > 0){
        echo "Email already registered!";
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if(mysqli_query($conn, $sql)) {
        $_SESSION['user'] = $username;
        header('Location: /index.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
