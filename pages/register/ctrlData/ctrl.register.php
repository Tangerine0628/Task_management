<?php
session_start();
include '../../../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT user_id FROM tbl_users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        header('location: ../register.php?error=email');
        exit;
    }

    $insert = mysqli_query($conn, "INSERT INTO tbl_users (first_name, last_name, email, password, role, status) 
        VALUES ('$first_name', '$last_name', '$email', '$password', 'User', 'Active')");

    if ($insert) {
        header('location: ../../login/login.php?registered=1');
    } else {
        header('location: ../register.php?error=failed');
    }
    exit;
}
?>