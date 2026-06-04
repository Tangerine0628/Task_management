<?php
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

if (!empty($_POST['task_ids'])) {
    foreach ($_POST['task_ids'] as $task_id) {
        $task_id = (int) $task_id;
        $user_id = $_SESSION['user_id'] ?? null;
        record_task_activity($conn, $task_id, $user_id, 'task_deleted', 'Task was deleted in a bulk action.');
        mysqli_query($conn, "DELETE FROM tbl_tasks WHERE task_id = '$task_id'");
    }
}

header('location: ../task.management.php?success=delete');
?>
