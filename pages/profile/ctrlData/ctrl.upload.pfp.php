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

// Check a file was actually submitted
if (empty($_FILES['profile_pic']) || $_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
    exit;
}

$file     = $_FILES['profile_pic'];
$maxSize  = 2 * 1024 * 1024; // 2 MB limit
$allowed  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

// Validate file size
if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File is too large. Maximum size is 2MB.']);
    exit;
}

// Validate MIME type using finfo for security (not just the extension)
$finfo    = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file['tmp_name']);

if (!in_array($mimeType, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, WEBP, and GIF are allowed.']);
    exit;
}

// Build the upload directory path relative to the project root
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/task_management/uploads/avatars/';

// Create the directory if it doesn't exist yet
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate a unique filename to avoid collisions
$ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'user_' . $user_id . '_' . time() . '.' . strtolower($ext);
$destPath = $uploadDir . $filename;

// Delete the user's old profile picture if one exists
$existing = mysqli_query($conn, "SELECT profile_pic FROM tbl_users WHERE user_id = $user_id LIMIT 1");
$row      = mysqli_fetch_assoc($existing);
if (!empty($row['profile_pic'])) {
    $oldFile = $uploadDir . $row['profile_pic'];
    if (file_exists($oldFile)) {
        unlink($oldFile);
    }
}

// Move the uploaded file to the avatars directory
if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save the file.']);
    exit;
}

// Save the new filename to the database
$filename_safe = mysqli_real_escape_string($conn, $filename);
$update = mysqli_query($conn, "UPDATE tbl_users SET profile_pic = '$filename_safe' WHERE user_id = $user_id");

if ($update) {
    echo json_encode(['success' => true, 'filename' => $filename]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>
