<?php
include '../../../includes/conn.php';
session_start();

$user_id = $_POST['user_id'];

if (isset($_POST['button'])) {
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $update = mysqli_query($conn, "UPDATE tbl_users SET role = '$role' WHERE user_id = '$user_id'");

    if ($update) {
        header('location: ../user.management.php?success=role');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>