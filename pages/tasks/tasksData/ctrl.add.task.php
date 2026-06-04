<?php
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

if (isset($_POST["button"])) {
    $task_title = mysqli_real_escape_string($conn, $_POST["task_title"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $assigned_to = mysqli_real_escape_string($conn, $_POST["assigned_to"]);
    $priority = mysqli_real_escape_string($conn, $_POST["priority"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);
    $due_date = mysqli_real_escape_string($conn, $_POST["due_date"]);

    mysqli_query($conn, "INSERT INTO tbl_tasks (task_title, description, assigned_to, priority, status, due_date) 
    VALUES ('$task_title', '$description', '$assigned_to', '$priority', '$status', '$due_date')");

    $task_id = mysqli_insert_id($conn);
    $user_id = $_SESSION['user_id'] ?? null;
    record_task_activity($conn, $task_id, $user_id, 'task_created', 'Task was created.');

    header('location: ../task.management.php?success=add');
}
?>
