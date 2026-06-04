<?php
// Load DB connection and start session
include '../../../includes/conn.php';
session_start();

// Get the target user ID from the form
$user_id = $_POST['user_id'];

// Handle form submission to change the user's role
if (isset($_POST['button'])) {

    // Sanitize the new role value
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Update the user's role in the database
    $update = mysqli_query($conn, "UPDATE tbl_users SET role = '$role' WHERE user_id = '$user_id'");

    // Redirect back with success or error flag
    if ($update) {
        header('location: ../user.management.php?success=role');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>