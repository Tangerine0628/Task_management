<?php
include '../../../includes/conn.php';
session_start();

if (isset($_POST['button'])) {
    $user_id = $_POST['user_id'];

    $delete = mysqli_query($conn, "DELETE FROM tbl_users WHERE user_id = '$user_id'");

    if ($delete) {
        header('location: ../user.management.php?success=delete');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>