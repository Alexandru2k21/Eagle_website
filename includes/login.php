<?php

session_start();

require 'db-connect.php';

$stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?"); $stmt->bind_param("s", $username); 


$username = $_POST['username']; 
$password = $_POST['password']; 


$stmt-> execute();
$stmt -> store_result();

if($stmt -> num_rows > 0) {
    $stmt -> bind_result($user_id, $hashed_password);
    $stmt -> fetch();

    if(password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        header('Location: Eagle_website/account.php');
        exit();
    } else {
        echo "invalid password";
    }
} else {
    echo "No user found with this email ";
}

$stmt -> close();
$conn-> close();


?>