<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Database connection (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studyparkdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Get the data from the POST request
$newUsername = isset($_POST['username']) ? trim($_POST['username']) : '';
$userId = $_SESSION['user_id'];  // Use the logged-in user's ID from the session

// Validate the input
if (empty($newUsername)) {
    echo json_encode(['success' => false, 'error' => 'Username cannot be empty']);
    exit;
}

// Sanitize input
$newUsername = htmlspecialchars($newUsername, ENT_QUOTES, 'UTF-8');

// Update the username in the session
$_SESSION['name'] = $newUsername;

// Update the username in the database
$stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
$stmt->bind_param("si", $newUsername, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update username']);
}

$stmt->close();
$conn->close();
?>
