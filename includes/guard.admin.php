<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /task_management/pages/login/login.php');
    exit;
}
?>