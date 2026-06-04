<?php
// Start session and load DB + PHPMailer
session_start();
include '../../../includes/conn.php';
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize the submitted email
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check whether the email belongs to a registered user
    $check = mysqli_query($conn, "SELECT user_id FROM tbl_users WHERE email = '$email'");
    if (mysqli_num_rows($check) === 0) {
        header('location: ../forgot_password.php?error=1');
        exit;
    }

    // Generate a secure random reset token and set a 60-minute expiry
    $token      = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+60 minutes'));

    // Invalidate any existing unused tokens for this email
    mysqli_query($conn, "UPDATE tbl_passreset SET used = 1 WHERE email = '$email' AND used = 0");

    // Insert the new token into the reset table
    mysqli_query($conn, "INSERT INTO tbl_passreset (email, token, expires_at, used) 
    VALUES ('$email', '$token', '$expires_at', 0)");

    // Send the reset link via email using PHPMailer + Mailtrap SMTP
    $mail = new PHPMailer(true);
    try {
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bd24bf543ab77f';
        $mail->Password   = '2ae267af8327ff';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 2525;

        // Set sender, recipient, subject, and plain-text body
        $mail->setFrom('no-reply@taskflow.com', 'TaskFlow');
        $mail->addAddress($email);
        $mail->Subject = 'TaskFlow — Password Reset';
        $mail->Body    = "Hi,\n\nClick the link below to reset your password:\n\n"
            . "http://localhost/task_management/pages/login/reset_password.php?token=$token&email=" . urlencode($email)
            . "\n\nThis link expires in 60 minutes.\n\nIf you didn't request this, ignore this email.";

        $mail->send();
        header('location: ../forgot_password.php?sent=1');

    } catch (Exception $e) {
        // Mail failed — redirect with error flag
        header('location: ../forgot_password.php?error=1');
    }
    exit;
}
?>