<?php
require_once '../../../includes/session.php';
require_once '../../../includes/conn.php';
require_once '../../../includes/task_activity.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$task_id = isset($_POST['task_id']) ? (int) $_POST['task_id'] : 0;
$comment = trim($_POST['comment'] ?? '');
$user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

if ($task_id < 1 || $comment === '') {
    echo json_encode(['success' => false, 'message' => 'Comment cannot be empty.']);
    exit;
}

$check = mysqli_query($conn, "SELECT task_id FROM tbl_tasks WHERE task_id = $task_id LIMIT 1");
if (!$check || mysqli_num_rows($check) === 0) {
    echo json_encode(['success' => false, 'message' => 'Task not found.']);
    exit;
}

$task = mysqli_fetch_assoc(mysqli_query($conn, "SELECT assigned_to FROM tbl_tasks WHERE task_id = $task_id LIMIT 1"));
if (($_SESSION['role'] ?? '') === 'User' && (int) $task['assigned_to'] !== $user_id) {
    echo json_encode(['success' => false, 'message' => 'You do not have access to this task.']);
    exit;
}

$comment_safe = mysqli_real_escape_string($conn, $comment);
$insert = mysqli_query($conn, "INSERT INTO tbl_task_comments (task_id, user_id, comment)
    VALUES ($task_id, $user_id, '$comment_safe')");

if (!$insert) {
    echo json_encode(['success' => false, 'message' => 'Failed to save comment.']);
    exit;
}

record_task_activity($conn, $task_id, $user_id, 'comment_added', 'Added a comment.');

echo json_encode(['success' => true]);
?>
