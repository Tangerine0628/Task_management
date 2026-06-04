<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'Admin') {
        header('Location: pages/dashboard/index.php');
    } else {
        header('Location: pages/dashboard/index2.php');
    }
} else {
    header('Location: pages/login/login.php');
}
exit;
?>