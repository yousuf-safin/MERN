<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../assets/login.html'); // Redirect to login if not logged in
    exit();
}
?>

<!-- Your form HTML goes here -->