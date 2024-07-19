<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

require 'includes/db-connect.php';

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Prepare and execute the query to get user details including the profile image
$stmt = $conn->prepare("SELECT username, email, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $profile_image);
$stmt->fetch();
$stmt->close();
$conn->close();
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
        <h2>Welcome to your account, <?php echo htmlspecialchars($username); ?></h2>
        <?php
        // Construct the relative path to the image
        $image_path = 'uploads/' . htmlspecialchars($profile_image);
        $full_image_path = __DIR__ . '/../uploads/' . htmlspecialchars($profile_image);

        // Debugging output
        echo '<!-- Image Path: ' . $image_path . ' -->';
        echo '<!-- Full Image Path: ' . $full_image_path . ' -->';

        // Check if the profile image is available and display it
        if (!empty($profile_image) && file_exists($full_image_path)): ?>
            <a href="#">
                <img src="<?php echo $image_path; ?>" alt="User Avatar" class="profile-img">
            </a>
        <?php else: ?>
            <a href="#">
                <img src="images/default-avatar.png" alt="Default Avatar" class="profile-img">
            </a>
        <?php endif; ?>
        <button class="cart-btn"><a href="#">Cart</a></button>
    </div>

    <footer>
        <div class="brand">
            <h3>Copyright © 2024, Eagle. All rights reserved.</h3>
        </div>
    </footer>
</body>
</html>
