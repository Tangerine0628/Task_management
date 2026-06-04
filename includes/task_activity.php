<?php

// Inserts a new activity log entry for a given task
function record_task_activity($conn, $task_id, $user_id, $action, $details = '')
{
    // Sanitize task and user IDs
    $task_id = (int) $task_id;
    $user_id_sql = $user_id ? (int) $user_id : "NULL"; // Use NULL if no user provided

    // Escape action and details strings to prevent SQL injection
    $action_safe = mysqli_real_escape_string($conn, $action);
    $details_safe = mysqli_real_escape_string($conn, $details);

    // Insert the activity record into the log table
    mysqli_query($conn, "INSERT INTO tbl_task_activity (task_id, user_id, action, details)
        VALUES ($task_id, $user_id_sql, '$action_safe', '$details_safe')");
}
?>