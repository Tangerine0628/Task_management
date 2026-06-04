<?php
// Load DB, activity logger, and start session
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

// Get and sanitize the target task ID from the URL
$task_id = (int) $_GET['task_id'];

// Log the deletion before removing the record
$user_id = $_SESSION['user_id'] ?? null;
record_task_activity($conn, $task_id, $user_id, 'task_deleted', 'Task was deleted.');

// Delete the task from the database
mysqli_query($conn, "DELETE FROM tbl_tasks WHERE task_id = '$task_id'");

// Redirect back with success flag
header('location: ../task.management.php?success=delete');
?>
