<?php

function record_task_activity($conn, $task_id, $user_id, $action, $details = '')
{
    $task_id = (int) $task_id;
    $user_id_sql = $user_id ? (int) $user_id : "NULL";
    $action_safe = mysqli_real_escape_string($conn, $action);
    $details_safe = mysqli_real_escape_string($conn, $details);

    mysqli_query($conn, "INSERT INTO tbl_task_activity (task_id, user_id, action, details)
        VALUES ($task_id, $user_id_sql, '$action_safe', '$details_safe')");
}
?>