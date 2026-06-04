<?php
// Load DB, activity logger, and start session
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

// Process each selected task ID and delete them one by one
if (!empty($_POST['task_ids'])) {
    foreach ($_POST['task_ids'] as $task_id) {

        // Sanitize each task ID before use
        $task_id = (int) $task_id;
        $user_id = $_SESSION['user_id'] ?? null;

        // Log the bulk deletion for this specific task
        record_task_activity($conn, $task_id, $user_id, 'task_deleted', 'Task was deleted in a bulk action.');

        // Delete the task from the database
        mysqli_query($conn, "DELETE FROM tbl_tasks WHERE task_id = '$task_id'");
    }
}

// Redirect back with success flag
header('location: ../task.management.php?success=delete');
?>
