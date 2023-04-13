<?php

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "log";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function db_connect() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'log';
  
    $conn = new mysqli($host, $user, $password, $database);
  
    if ($conn->connect_error) {
      die('Failed to connect to database: ' . $conn->connect_error);
    }
  
    return $conn;
  }
  

?>
