<?php 
session_start();

require __DIR__ .'/../config/database.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = trim($_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['user'] = $user['username'];
            header("location: /index.php");
        }else{
            echo "Wrong password";
        }
    }else{
        echo "No user found with this email";
    }
}

?>