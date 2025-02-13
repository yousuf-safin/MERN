<?php
session_start();
session_destroy();
header('Location: assets/login.html'); // Redirect to login page
exit();
?>