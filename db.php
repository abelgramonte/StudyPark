<?php
// Database credentials
$servername = "localhost";  // Replace with your database server name if different
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "StudyParkDB";      // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF-8 to handle special characters properly
$conn->set_charset("utf8");

?>
