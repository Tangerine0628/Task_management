<?php
// Load DB, activity logger, and start session
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

// Handle form submission to create a new task
if (isset($_POST["button"])) {

    // Sanitize all task fields from the form
    $task_title  = mysqli_real_escape_string($conn, $_POST["task_title"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $assigned_to = mysqli_real_escape_string($conn, $_POST["assigned_to"]);
    $priority    = mysqli_real_escape_string($conn, $_POST["priority"]);
    $status      = mysqli_real_escape_string($conn, $_POST["status"]);
    $due_date    = mysqli_real_escape_string($conn, $_POST["due_date"]);

    // Insert the new task into the database
    mysqli_query($conn, "INSERT INTO tbl_tasks (task_title, description, assigned_to, priority, status, due_date) 
    VALUES ('$task_title', '$description', '$assigned_to', '$priority', '$status', '$due_date')");

    // Get the newly created task ID and log the creation activity
    $task_id = mysqli_insert_id($conn);
    $user_id = $_SESSION['user_id'] ?? null;
    record_task_activity($conn, $task_id, $user_id, 'task_created', 'Task was created.');

    // Redirect back with success flag
    header('location: ../task.management.php?success=add');
}
?>
