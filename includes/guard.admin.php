<?php
// Block access if the logged-in user is not an Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /task_management/pages/login/login.php');
    exit;
}
?>