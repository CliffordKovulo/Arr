<?php
// Include necessary files
require_once "config.php";
require_once "functions.php";

// Initialize variables
$username = "";
$email = "";
$gender = "";
$id_number = "";
$password = "";
$confirm_password = "";
$error = "";
$registration = "register.php";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $gender = trim($_POST["gender"]);
    $id_number = trim($_POST["id_number"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate form data
    if (empty($username)) {
        $error = "Please enter your username";
    } elseif (empty($email)) {
        $error = "Please enter your email address";
    } elseif (empty($gender)) {
        $error = "Please select your gender";
    } elseif (empty($id_number)) {
        $error = "Please enter your ID number";
    } elseif (empty($password)) {
        $error = "Please enter your password";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Check if email is already in use
        $existing_user = get_user_by_email($email);
        if ($existing_user) {
            $error = "Email already in use";
        } else {
            // Check if ID number is already in use
            $existing_user = get_user_by_id_number($id_number);
            if ($existing_user) {
                $error = "ID number already in use";
            } else {
                // Attempt to register user
                $result = register_user($username, $email, $gender, $id_number, $password);
                if ($result === true) {
                    // Registration successful, redirect to login page
                    //header("Location: randompage.html");
                    echo "<script>alert ('successful registration');</script>";
                    echo "<script>window.location.href='randompage.html';</script>";
                    exit;
                } else {
                    $error = $result;
                }
            }
        }
    }
}

// Redirect to welcome.php after successful registration
if (!empty($error)) {
    echo $error;
} elseif ($registration) {
    echo "<script>alert ('successful registration');</script>";
    header("Location: randompage.html");
    exit();
}
?>
