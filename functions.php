<?php

// Include config file
require_once "config.php";

// Function to register new users
function register_user($username, $email, $gender, $id_number, $password) {
    global $conn;
    
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (username, email, gender, id_number, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $gender, $id_number, $password);
    
    // Execute statement and return success status
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function get_user_by_email($email) {
    global $conn;
  
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
  
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();
      return $user;
    } else {
      return false;
    }
}

function get_user_by_id_number($id_number) {
    global $conn;
    
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE id_number = ?");
    
    // Bind parameters and execute query
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    
    // Get query result
    $result = $stmt->get_result();
    
    // Check if user was found
    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}
  
function get_user_by_id($id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}
  
// Function to log in existing users
function login_user($email, $password) {
    global $conn;
    
    // Prepare and bind parameters
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    // Execute statement and fetch result
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists and verify password
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start session and redirect to dashboard
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header("location: dashboard.php");
            exit();
        } else {
            // Password is incorrect, show error message
            $error = "Invalid password";
        }
    } else {
        // User does not exist, show error message
        $error = "User not found";
    }
    
    return $error;
}

?>
