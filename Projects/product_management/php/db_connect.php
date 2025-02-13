<?php
$host = "localhost";
$user = "lookovec_product_management";  // Change if needed
$password = "2++(&*$#9Ct8";  // Change if needed
$database = "lookovec_product_management";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
