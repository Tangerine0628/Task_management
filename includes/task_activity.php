<?php
function ensure_task_collaboration_tables($conn)
{
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS tbl_task_comments (
        comment_id INT AUTO_INCREMENT PRIMARY KEY,
        task_id INT NOT NULL,
        user_id INT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_task_comments_task_id (task_id),
        INDEX idx_task_comments_user_id (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS tbl_task_activity (
        activity_id INT AUTO_INCREMENT PRIMARY KEY,
        task_id INT NOT NULL,
        user_id INT NULL,
        action VARCHAR(60) NOT NULL,
        details TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_task_activity_task_id (task_id),
        INDEX idx_task_activity_user_id (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function record_task_activity($conn, $task_id, $user_id, $action, $details = '')
{
    ensure_task_collaboration_tables($conn);

    $task_id = (int) $task_id;
    $user_id_sql = $user_id ? (int) $user_id : "NULL";
    $action_safe = mysqli_real_escape_string($conn, $action);
    $details_safe = mysqli_real_escape_string($conn, $details);

    mysqli_query($conn, "INSERT INTO tbl_task_activity (task_id, user_id, action, details)
        VALUES ($task_id, $user_id_sql, '$action_safe', '$details_safe')");
}
?>
