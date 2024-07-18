<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();

}

require 'includes/db-connect.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn -> prepare("SELECT username, email FROM users WHERE id = ?");
$stmt -> bind_param("i" , $user_id);
$stmt -> execute();
$stmt -> bind_result($username, $email);
$stmt -> fetch();
$stmt -> close();
$conn -> close();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eagle</title>
    <link rel="stylesheet" href="styles/account.css">
    <script type="text/javascript" src="main.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">

</head>
<body>
    <header>
        <h1><a href="index.html">Eagle</a></h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="products.html">Products</a></li>
                <li><a href="about-us.html">About Us</a></li>
                <div class="dropdown">
                    <button class="dropbtn">
                        <li><a href="account.php">Account</a></li>
                    </button>
                    <div class="dropdown-content">
                        <a href="login.html">Login</a>
                        <a href="sign-up.html">Sign up</a>
                    </div>
                  </div>
            </ul>
        </nav>
    </header>

    <div class="profile">

    <h2> Welcome to your account </h2>
    <a href="#">
    <img src="images/isagi-avatar-pfp.jpg" alt="">
    </a>
        
    <button class="cart-btn"><a href="#">Cart</a></button>

    </div>

    
    <footer>
        <div class="brand">
            <h3>Copyright © 2024, Eagle.All rights reserved </h3>
        </div>
    </footer>
</body>
</html>