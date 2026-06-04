<?php
// Require session, auth, and DB connection — JSON response only
require_once '../../../includes/session.php';
require_once '../../../includes/conn.php';
require_once '../../../includes/task_activity.php';

header('Content-Type: application/json');

// Get and validate the task ID from the query string
$task_id = isset($_GET['task_id']) ? (int) $_GET['task_id'] : 0;

if ($task_id < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid task.']);
    exit;
}

// Fetch the task along with the assignee's full name
$task_result = mysqli_query($conn, "SELECT tbl_tasks.*, CONCAT(tbl_users.first_name, ' ', tbl_users.last_name) AS assignee_name
    FROM tbl_tasks
    LEFT JOIN tbl_users ON tbl_tasks.assigned_to = tbl_users.user_id
    WHERE tbl_tasks.task_id = $task_id
    LIMIT 1");

if (!$task_result || mysqli_num_rows($task_result) === 0) {
    echo json_encode(['success' => false, 'message' => 'Task not found.']);
    exit;
}

$task = mysqli_fetch_assoc($task_result);

// Restrict regular users to only view tasks assigned to them
if (($_SESSION['role'] ?? '') === 'User' && (int) $task['assigned_to'] !== (int) $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'You do not have access to this task.']);
    exit;
}

// Fetch all comments for this task, newest first
$comments = [];
$comments_result = mysqli_query($conn, "SELECT c.comment_id, c.comment, c.created_at,
        CONCAT(u.first_name, ' ', u.last_name) AS author_name
    FROM tbl_task_comments c
    LEFT JOIN tbl_users u ON c.user_id = u.user_id
    WHERE c.task_id = $task_id
    ORDER BY c.created_at DESC");

while ($row = mysqli_fetch_assoc($comments_result)) {
    $comments[] = $row;
}

// Fetch the last 30 activity log entries for this task, newest first
$activity = [];
$activity_result = mysqli_query($conn, "SELECT a.activity_id, a.action, a.details, a.created_at,
        CONCAT(u.first_name, ' ', u.last_name) AS actor_name
    FROM tbl_task_activity a
    LEFT JOIN tbl_users u ON a.user_id = u.user_id
    WHERE a.task_id = $task_id
    ORDER BY a.created_at DESC
    LIMIT 30");

while ($row = mysqli_fetch_assoc($activity_result)) {
    $activity[] = $row;
}

// Return task details, comments, and activity as JSON
echo json_encode([
    'success'  => true,
    'task'     => $task,
    'comments' => $comments,
    'activity' => $activity
]);
?>