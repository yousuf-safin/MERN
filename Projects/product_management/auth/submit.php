<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Handle file upload
$target_dir = "../uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$image_name = basename($_FILES['image']['name']);
$target_file = $target_dir . $image_name;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is valid
$check = getimagesize($_FILES['image']['tmp_name']);
if ($check === false) {
    echo json_encode(['success' => false, 'error' => 'File is not an image.']);
    exit();
}

// Move uploaded file
if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
    echo json_encode(['success' => false, 'error' => 'Failed to upload image.']);
    exit();
}

// Insert data into database
$stmt = $conn->prepare("INSERT INTO products (name, price, date, quantity, sold_by, location, image_path, user_id) VALUES (:name, :price, :date, :quantity, :sold_by, :location, :image_path, :user_id)");
$stmt->execute([
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'date' => $_POST['date'],
    'quantity' => $_POST['quantity'],
    'sold_by' => $username,
    'location' => $_POST['location'],
    'image_path' => $target_file,
    'user_id' => $user_id
]);

echo json_encode(['success' => true]);
?>