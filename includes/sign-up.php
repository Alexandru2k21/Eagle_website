<?php
session_start();

require 'db-connect.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $conn->insert_id; 
    $_SESSION['username'] = $username;
    header('Location: /Eagle_website/account.php'); 
    exit();
} else {
    echo "Error: " . $stmt->error;
}





$stmt->close();
$conn->close();
?>
