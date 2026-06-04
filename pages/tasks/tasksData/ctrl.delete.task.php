<?php
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

$task_id = (int) $_GET['task_id'];

$user_id = $_SESSION['user_id'] ?? null;
record_task_activity($conn, $task_id, $user_id, 'task_deleted', 'Task was deleted.');

mysqli_query($conn, "DELETE FROM tbl_tasks WHERE task_id = '$task_id'");

header('location: ../task.management.php?success=delete');
?>
