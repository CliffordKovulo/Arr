<?php

// Include necessary files
require_once "config.php";
require_once "functions.php";

// Initialize variables
$email = "";
$password = "";
$error_message = '';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validate form data
    if (empty($email)) {
        $error_message = "Please enter your email address";
    } elseif (empty($password)) {
        $error_message = "Please enter your password";
    } else {
        // Check if user exists
        $user = get_user_by_email($email);
        if (!$user) {
            $error_message = "Invalid email or password";
        } else {
            // Check if password is correct
            if (password_verify($password, $user["password"])) {
                // Password is correct, start session and redirect to dashboard
                session_start();
                $_SESSION["user_id"] = $user["id"];
                echo "<script>alert ('successful login');</script>";
                header("Location: randompage.html");
                exit();
            } else {
                // Password is incorrect
                $error_message = "Invalid email or password";
            }
        }
    }
}
?>
