<?php
// Start session to access session variables
session_start();

// Redirect user based on their role, or to login if not logged in
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'Admin') {
        // Admin goes to the admin dashboard
        header('Location: pages/dashboard/index.php');
    } else {
        // Regular user goes to the user dashboard
        header('Location: pages/dashboard/index2.php');
    }
} else {
    // No session found — send to login page
    header('Location: pages/login/login.php');
}
exit;
?>