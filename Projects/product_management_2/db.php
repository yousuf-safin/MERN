<?php
$host = 'localhost'; // Replace with your database host
$dbname = 'lookovec_product_management'; // Replace with your database name
$username = 'lookovec_product_management'; // Replace with your database username
$password = '2++(&*$#9Ct8'; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Remove this line after testing
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>