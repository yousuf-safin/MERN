<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// You can access $_SESSION['username'] to personalize the greeting
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is your dashboard.</p>
    <ul>
        <li><a href="form.php">Submit New Product</a></li>
        <li><a href="table.php">View Products</a></li>
        <li><a href="auth/logout.php">Logout</a></li>
    </ul>
</body>
</html>
