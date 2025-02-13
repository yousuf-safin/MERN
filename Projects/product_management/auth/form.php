<?php
session_start();
require_once 'auth/db.php'; // Ensure the path to your database connection script is correct

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $date = htmlspecialchars($_POST['date']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $location = htmlspecialchars($_POST['location']);

    // Handle the file upload
    $file = $_FILES['file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif']; // Allowed file types
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($fileExt, $allowed)) {
            $newFilePath = "uploads/" . uniqid("img_", true) . '.' . $fileExt; // Create a unique file name
            if (move_uploaded_file($file['tmp_name'], $newFilePath)) {
                // File upload successful, proceed with database insertion
                $stmt = $conn->prepare("INSERT INTO products (name, price, date, quantity, sold_by, location, image_path, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $sold_by = $_SESSION['username']; // Get username from session
                $user_id = $_SESSION['user_id']; // Get user ID from session
                $stmt->bind_param("ssdisssi", $name, $price, $date, $quantity, $sold_by, $location, $newFilePath, $user_id);
                if ($stmt->execute()) {
                    echo "Product added successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type.";
        }
    } else {
        echo "Error in file upload: " . $file['error'];
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Product</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Submit New Product</h1>
    <form action="form.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
        </div>
        <div class="form-group">
            <label for="file">Image File:</label>
            <input type="file" id="file" name="file" required>
        </div>
        <button type="submit">Submit Product</button>
    </form>
</body>
</html>
