<?php
require_once('db_connect.php');
require_once('auth.php'); // To check if user is authenticated

// Query to get all users
$sql = "SELECT username FROM users";
$result = $conn->query($sql);

// Prepare an array of usernames
$usernames = [];
while ($row = $result->fetch_assoc()) {
    $usernames[] = $row['username'];
}

// Return the usernames as a JSON response
echo json_encode($usernames);
?>
