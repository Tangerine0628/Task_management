<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('location: /task_management/pages/login/login.php');
    exit;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/task_management/includes/conn.php';
$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM tbl_users WHERE user_id = $uid LIMIT 1");
$currentUser = mysqli_fetch_assoc($res);
?>