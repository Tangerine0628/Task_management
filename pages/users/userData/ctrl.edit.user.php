<?php
include '../../../includes/conn.php';
session_start();

$user_id = $_POST['user_id'];

if (isset($_POST['button'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $edit_user = mysqli_query($conn, "UPDATE tbl_users SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email' 
        WHERE user_id = '$user_id'");

    if ($edit_user) {
        header('location: ../user.management.php?success=edit');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>