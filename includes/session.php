<?php
// Start session only if one isn't already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header('location: /task_management/pages/login/login.php');
    exit;
}

// Load the database connection
include_once $_SERVER['DOCUMENT_ROOT'] . '/task_management/includes/conn.php';

// Fetch the logged-in user's full record from the database
$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM tbl_users WHERE user_id = $uid LIMIT 1");
$currentUser = mysqli_fetch_assoc($res);
?>