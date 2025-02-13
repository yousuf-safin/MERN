<?php
include 'auth.php';  // Ensure the user is logged in
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM products WHERE user_id='$user_id'";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
} else {
    echo "No products found";
}
?>
