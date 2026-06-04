<?php
require_once '../../../includes/session.php';
require_once '../../../includes/guard.admin.php';
require_once '../../../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int) $_POST['user_id'];
    $status = $_POST['status'] === 'Active' ? 'Active' : 'Inactive';
    mysqli_query($conn, "UPDATE tbl_users SET status = '$status' WHERE user_id = $user_id");
    header('Location: ../user.management.php?success=status');
    exit;
}
?>