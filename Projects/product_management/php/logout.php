<?php
session_start();  // Start the session to access session variables

// Clear session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../index.html");
exit();
?>
