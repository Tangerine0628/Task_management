<?php
// Load DB connection and start session
include '../../../includes/conn.php';
session_start();

// Handle form submission to delete a user
if (isset($_POST['button'])) {
    $user_id = $_POST['user_id'];

    // Delete the user record by ID
    $delete = mysqli_query($conn, "DELETE FROM tbl_users WHERE user_id = '$user_id'");

    // Redirect back with success or error flag
    if ($delete) {
        header('location: ../user.management.php?success=delete');
    } else {
        header('location: ../user.management.php?error=1');
    }
    exit;
}
?>