<?php
include '../../../includes/conn.php';
include '../../../includes/task_activity.php';
session_start();

$task_id = (int) $_POST['task_id'];

if (isset($_POST['button'])) {
    $before_result = mysqli_query($conn, "SELECT * FROM tbl_tasks WHERE task_id = $task_id LIMIT 1");
    $before = $before_result ? mysqli_fetch_assoc($before_result) : null;

    $task_title = mysqli_real_escape_string($conn, $_POST['task_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $assignee = mysqli_real_escape_string($conn, $_POST['assigned_to']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "UPDATE tbl_tasks SET 
    task_title = '$task_title', 
    description = '$description', 
    assigned_to = '$assignee', 
    due_date = '$due_date', 
    priority = '$priority', 
    status = '$status'
    WHERE task_id = '$task_id'");

    $changes = [];
    if ($before) {
        $fields = [
            'task_title' => 'title',
            'description' => 'description',
            'assigned_to' => 'assignee',
            'due_date' => 'due date',
            'priority' => 'priority',
            'status' => 'status'
        ];

        foreach ($fields as $field => $label) {
            $old = (string) ($before[$field] ?? '');
            $new = (string) ($_POST[$field] ?? ($_POST['assigned_to'] ?? ''));
            if ($old !== $new) {
                $changes[] = ucfirst($label) . " changed from '" . ($old === '' ? 'empty' : $old) . "' to '" . ($new === '' ? 'empty' : $new) . "'";
            }
        }
    }

    $user_id = $_SESSION['user_id'] ?? null;
    record_task_activity($conn, $task_id, $user_id, 'task_updated', $changes ? implode('; ', $changes) . '.' : 'Task was updated.');

    header('location: ../task.management.php?success=edit');
}
?>
