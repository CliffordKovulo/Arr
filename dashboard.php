<?php

  // Include necessary files
  require_once "config.php";
  require_once "functions.php";
  
  // Start session and check if user is logged in
  session_start();
  if (!isset($_SESSION["user_id"])) {
      // Redirect to login page
      header("Location: randompage.html");
      exit;
  }
  
  // Retrieve user data
  $user_id = $_SESSION["user_id"];
  $user = get_user_by_id($user_id);

  
?>