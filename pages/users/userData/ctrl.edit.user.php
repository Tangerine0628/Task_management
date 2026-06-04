<?php
// Load DB connection and start session
include '../../../includes/conn.php';
session_start();

// Get the target user ID from the form
$user_id = $_POST['user_id'];

// Handle form submission to update user profile fields
if (isset($_POST['button'])) {

    // Sanitize name and email fields
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);

    // Update the user record in the database
    $edit_user = mysqli_query($conn, "UPDATE tbl_users SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email' 
        WHERE user_id = '$user_id'");

    // Redirect back with success or error flag
    if ($edit_user) {
        header('location: ../user.management.php?success=edit');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>