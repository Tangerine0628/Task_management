<?php
// Start session and load DB connection
session_start();
include '../../../includes/conn.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize all registration fields
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);

    // Hash the password before storing
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email is already registered
    $check = mysqli_query($conn, "SELECT user_id FROM tbl_users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        header('location: ../register.php?error=email');
        exit;
    }

    // Insert the new user with the default role of 'User' and Active status
    $insert = mysqli_query($conn, "INSERT INTO tbl_users (first_name, last_name, email, password, role, status) 
        VALUES ('$first_name', '$last_name', '$email', '$password', 'User', 'Active')");

    // Redirect to login on success, or back with error on failure
    if ($insert) {
        header('location: ../../login/login.php?registered=1');
    } else {
        header('location: ../register.php?error=failed');
    }
    exit;
}
?>