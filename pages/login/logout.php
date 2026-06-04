<?php
// Destroy the session and redirect to login
session_start();
session_destroy();
header('location: login.php');
exit;
?>