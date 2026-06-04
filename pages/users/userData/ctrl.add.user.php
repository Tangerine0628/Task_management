<?php
include '../../../includes/conn.php';
session_start();

if (isset($_POST["button"])) {
    $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);

    $insert_user = mysqli_query($conn, "INSERT INTO tbl_users (first_name, last_name, email, password, role, status) 
    VALUES ('$first_name', '$last_name', '$email', '$password', '$role', 'Active')");

    if ($insert_user) {
        header('location: ../user.management.php?success=add');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>