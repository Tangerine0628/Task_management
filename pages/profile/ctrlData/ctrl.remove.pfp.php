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

$user_id = $_SESSION['user_id'];

// Fetch the current profile pic filename
$result = mysqli_query($conn, "SELECT profile_pic FROM tbl_users WHERE user_id = $user_id LIMIT 1");
$row    = mysqli_fetch_assoc($result);

// Delete the physical file if it exists
if (!empty($row['profile_pic'])) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/task_management/uploads/avatars/' . $row['profile_pic'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Clear the profile_pic column in the database
$update = mysqli_query($conn, "UPDATE tbl_users SET profile_pic = NULL WHERE user_id = $user_id");

if ($update) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>
