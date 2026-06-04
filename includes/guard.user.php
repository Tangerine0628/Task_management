<?php
// Block access if the logged-in user is not a regular User
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'User') {
    header('Location: /task_management/pages/login/login.php');
    exit;
}
?>