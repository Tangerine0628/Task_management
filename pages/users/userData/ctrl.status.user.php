<?php
// Require auth and admin guard before processing
require_once '../../../includes/session.php';
require_once '../../../includes/guard.admin.php';
require_once '../../../includes/conn.php';

// Handle POST request to toggle a user's Active/Inactive status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize user ID and validate status value
    $user_id = (int) $_POST['user_id'];
    $status  = $_POST['status'] === 'Active' ? 'Active' : 'Inactive';

    // Update the user's status in the database
    mysqli_query($conn, "UPDATE tbl_users SET status = '$status' WHERE user_id = $user_id");

    // Redirect back with success flag
    header('Location: ../user.management.php?success=status');
    exit;
}
?>