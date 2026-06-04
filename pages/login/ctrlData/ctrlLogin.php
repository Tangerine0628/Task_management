<?php
session_start();
include '../../../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE email = '$email' LIMIT 1");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['status'] === 'Inactive') {
            header('Location: ../login.php?error=inactive');
            exit;
        }
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['role'] = $user['role'];

        if (isset($_POST['remember_me'])) {
            setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/'); // 30 days
        }

        if ($user['role'] === 'Admin') {
            header('Location: ../../dashboard/index.php');
        } else {
            header('Location: ../../dashboard/index2.php');
        }
    } else {
        header('location: ../login.php?error=1');
    }
    exit;
}
?>