<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db-connect.php';

// Debugging: Print form data and file info
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_image'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_image = $_FILES['profile_image'];

    // Validate and upload the profile image
    $target_dir = __DIR__ . "/uploads/"; // Absolute path to uploads directory
    $target_file = $target_dir . basename($profile_image["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    if (isset($profile_image["tmp_name"]) && $profile_image["tmp_name"]) {
        $check = getimagesize($profile_image["tmp_name"]);
        if ($check !== false) {
            $upload_ok = 1;
        } else {
            echo "File is not an image.";
            $upload_ok = 0;
        }
    } else {
        echo "No file uploaded.";
        $upload_ok = 0;
    }

    // Check file size (5MB max)
    if ($profile_image["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $upload_ok = 0;
    }

    // Allow certain file formats
    if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $upload_ok = 0;
    }

    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($profile_image["tmp_name"], $target_file)) {
            // File is uploaded, proceed with database insertion
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, profile_image) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssss", $username, $email, $hashed_password, $target_file);

                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $conn->insert_id;
                    $_SESSION['username'] = $username;
                    header('Location: /Eagle_website/account.php');
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing the statement.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
} else {
    echo "Invalid form submission.";
}
?>
