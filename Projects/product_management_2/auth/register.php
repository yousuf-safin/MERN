<?php
require_once 'db.php';  // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hashing the password
    $email = htmlspecialchars($_POST['email']);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the login page on successful registration
        header("Location: ../login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
