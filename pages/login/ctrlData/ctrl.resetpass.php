<?php
// Start session and load DB connection
session_start();
include '../../../includes/conn.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../forgot_password.php');
    exit;
}

// Collect form values
$token    = $_POST['token'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

// Reject if any required field is missing
if (!$token || !$email || !$password || !$confirm) {
    header('location: ../reset_password.php?token=' . urlencode($token)
        . '&email=' . urlencode($email) . '&error=1');
    exit;
}

// Enforce minimum length and matching passwords
if (strlen($password) < 8 || $password !== $confirm) {
    header('location: ../reset_password.php?token=' . urlencode($token)
        . '&email=' . urlencode($email) . '&error=1');
    exit;
}

// Sanitize token and email before querying
$email_safe = mysqli_real_escape_string($conn, $email);
$token_safe = mysqli_real_escape_string($conn, $token);

// Re-validate the token: must be unused and not expired
$check = mysqli_query($conn, "SELECT pass_id FROM tbl_passreset
    WHERE token      = '$token_safe' 
      AND email      = '$email_safe' 
      AND used       = 0 
      AND expires_at > NOW()
    LIMIT 1");

if (mysqli_num_rows($check) === 0) {
    // Token is invalid or expired — send back to the start
    header('location: ../forgot_password.php?error=expired');
    exit;
}

// Hash the new password using bcrypt
$hashed = password_hash($password, PASSWORD_BCRYPT);

// Update the user's password in the database
$update = mysqli_query($conn, "UPDATE tbl_users 
    SET password = '$hashed' 
    WHERE email  = '$email_safe' 
    LIMIT 1");

if (!$update || mysqli_affected_rows($conn) === 0) {
    header('location: ../reset_password.php?token=' . urlencode($token)
        . '&email=' . urlencode($email) . '&error=1');
    exit;
}

// Mark the token as used so it cannot be reused
mysqli_query($conn, "UPDATE tbl_passreset 
    SET used = 1 
    WHERE token = '$token_safe' AND email = '$email_safe'");

// Redirect to login with a success flag
header('location: ../login.php?reset=1');
exit;
?>