<?php
// Start session and load DB connection
session_start();
include '../../../includes/conn.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize the email input and grab the raw password
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Look up the user by email
    $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE email = '$email' LIMIT 1");
    $user   = mysqli_fetch_assoc($result);

    // Verify password hash matches the stored record
    if ($user && password_verify($password, $user['password'])) {

        // Block login if the account has been deactivated
        if ($user['status'] === 'Inactive') {
            header('Location: ../login.php?error=inactive');
            exit;
        }

        // Store user info in the session
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['role']      = $user['role'];

        // Set a remember-me cookie for 30 days if the checkbox was ticked
        if (isset($_POST['remember_me'])) {
            setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
        }

        // Redirect to the appropriate dashboard based on role
        if ($user['role'] === 'Admin') {
            header('Location: ../../dashboard/index.php');
        } else {
            header('Location: ../../dashboard/index2.php');
        }

    } else {
        // Credentials did not match — redirect with error flag
        header('location: ../login.php?error=1');
    }
    exit;
}
?>