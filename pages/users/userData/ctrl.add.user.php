<?php
// Load DB connection and start session
include '../../../includes/conn.php';
session_start();

// Handle form submission to add a new user
if (isset($_POST["button"])) {

    // Sanitize all incoming user fields
    $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
    $last_name  = mysqli_real_escape_string($conn, $_POST["last_name"]);
    $email      = mysqli_real_escape_string($conn, $_POST["email"]);
    $role       = mysqli_real_escape_string($conn, $_POST["role"]);

    // Hash the password before storing
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Insert the new user with Active status by default
    $insert_user = mysqli_query($conn, "INSERT INTO tbl_users (first_name, last_name, email, password, role, status) 
    VALUES ('$first_name', '$last_name', '$email', '$password', '$role', 'Active')");

    // Redirect back with success or error flag
    if ($insert_user) {
        header('location: ../user.management.php?success=add');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>