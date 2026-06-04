<?php
// Require session, auth, and DB connection — JSON response only
require_once '../../../includes/session.php';
require_once '../../../includes/conn.php';
require_once '../../../includes/task_activity.php';

header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Sanitize and validate inputs
$task_id = isset($_POST['task_id']) ? (int) $_POST['task_id'] : 0;
$comment = trim($_POST['comment'] ?? '');
$user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

// Reject if task ID or comment is missing
if ($task_id < 1 || $comment === '') {
    echo json_encode(['success' => false, 'message' => 'Comment cannot be empty.']);
    exit;
}

// Verify the task exists before proceeding
$check = mysqli_query($conn, "SELECT task_id FROM tbl_tasks WHERE task_id = $task_id LIMIT 1");
if (!$check || mysqli_num_rows($check) === 0) {
    echo json_encode(['success' => false, 'message' => 'Task not found.']);
    exit;
}

// Restrict regular users to only comment on tasks assigned to them
$task = mysqli_fetch_assoc(mysqli_query($conn, "SELECT assigned_to FROM tbl_tasks WHERE task_id = $task_id LIMIT 1"));
if (($_SESSION['role'] ?? '') === 'User' && (int) $task['assigned_to'] !== $user_id) {
    echo json_encode(['success' => false, 'message' => 'You do not have access to this task.']);
    exit;
}

// Save the comment to the database
$comment_safe = mysqli_real_escape_string($conn, $comment);
$insert = mysqli_query($conn, "INSERT INTO tbl_task_comments (task_id, user_id, comment)
    VALUES ($task_id, $user_id, '$comment_safe')");

if (!$insert) {
    echo json_encode(['success' => false, 'message' => 'Failed to save comment.']);
    exit;
}

// Log the comment activity and return success
record_task_activity($conn, $task_id, $user_id, 'comment_added', 'Added a comment.');
echo json_encode(['success' => true]);
?>
