<?php

session_start();

$servername = "127.0.0.1";
$username = "root";
$password  = "";
$dbname = "eagle-shop";


$conn = new mysqli($servername,$username,$password, $dbname );

if ($conn -> connect_error) {
    die("Error connecting to the database:" . $conn -> connect_error );
} 

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn ->prepare("SELECT password FROM users WHERE email = ?");
$stmt ->bind_param("s", $email);
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