<?php
session_start();
require '../db.php'; // Include the database connection

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

// Fetch user from the database
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Login successful
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    echo json_encode(['success' => true]);
} else {
    // Login failed
    echo json_encode(['success' => false]);
}
?>