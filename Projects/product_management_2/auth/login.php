<?php
session_start();  // Start a new session
require_once 'db.php';  // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];  // Get the submitted password

    // Prepare a select statement to check the user in the database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        // Check if the user exists
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];  // Store data in session variables
            header("Location: welcome.php");  // Redirect user to welcome page
            exit();
        } else {
            // Display an error message if password is not valid
            echo 'Invalid password.';
        }
    } else {
        // Display an error message if username doesn't exist
        echo 'Invalid username.';
    }

    $stmt->close();
}

$conn->close();
?>
