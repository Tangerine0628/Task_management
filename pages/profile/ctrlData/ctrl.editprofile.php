<?php
// Require session and DB connection — returns JSON response
require_once '../../../includes/session.php';
require_once '../../../includes/conn.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Sanitize and trim the incoming profile fields
$first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
$last_name  = mysqli_real_escape_string($conn, trim($_POST['last_name']));
$email      = mysqli_real_escape_string($conn, trim($_POST['email']));
$user_id    = $_SESSION['user_id'];

// Reject if any field is blank or email format is invalid
if (!$first_name || !$last_name || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Ensure the email isn't already taken by a different user
$check = mysqli_query($conn, "SELECT user_id FROM tbl_users WHERE email = '$email' AND user_id != $user_id");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already in use.']);
    exit;
}

// Apply the profile update to the logged-in user's record
$update = mysqli_query($conn, "UPDATE tbl_users 
    SET first_name = '$first_name', last_name = '$last_name', email = '$email'
    WHERE user_id = $user_id");

// Return success or DB error as JSON
if ($update) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>