<?php
session_start();
include '../../../includes/conn.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../forgot_password.php');
    exit;
}

$token = $_POST['token'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

// ── Basic presence check ──────────────────────────────────────────────────────
if (!$token || !$email || !$password || !$confirm) {
    header('location: ../reset_password.php?token=' . urlencode($token)
        . '&email=' . urlencode($email) . '&error=1');
    exit;
}

// ── Password rules: min 8 chars, must match ───────────────────────────────────
if (strlen($password) < 8 || $password !== $confirm) {
    header('location: ../reset_password.php?token=' . urlencode($token)
        . '&email=' . urlencode($email) . '&error=1');
    exit;
}

// ── Sanitize ──────────────────────────────────────────────────────────────────
$email_safe = mysqli_real_escape_string($conn, $email);
$token_safe = mysqli_real_escape_string($conn, $token);

// ── Re-validate token (still valid, unused, not expired) ─────────────────────
$check = mysqli_query($conn, "SELECT pass_id FROM tbl_passreset
    WHERE token      = '$token_safe' 
      AND email      = '$email_safe' 
      AND used       = 0 
      AND expires_at > NOW()
    LIMIT 1");

if (mysqli_num_rows($check) === 0) {
    // Token expired or already used — send them back to start
    header('location: ../forgot_password.php?error=expired');
    exit;
}

// ── Hash the new password ─────────────────────────────────────────────────────
$hashed = password_hash($password, PASSWORD_BCRYPT);

// ── Update user's password ────────────────────────────────────────────────────
$update = mysqli_query($conn, "UPDATE tbl_users 
    SET password = '$hashed' 
    WHERE email  = '$email_safe' 
    LIMIT 1");

if (!$update || mysqli_affected_rows($conn) === 0) {
    header('location: ../reset_password.php?token=' . urlencode($token)
        . '&email=' . urlencode($email) . '&error=1');
    exit;
}

// ── Mark token as used ────────────────────────────────────────────────────────
mysqli_query($conn, "UPDATE tbl_passreset 
    SET used = 1 
    WHERE token = '$token_safe' AND email = '$email_safe'");

// ── Done — redirect to login with success flag ────────────────────────────────
header('location: ../login.php?reset=1');
exit;
?>