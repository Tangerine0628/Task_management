<?php
// Require auth, user guard, and DB — then load the shared profile template
require_once '../../includes/session.php';
require_once '../../includes/guard.user.php';
require_once '../../includes/conn.php';

// Point the profile template to the user sidebar
$sidebar_path = '../../includes/user-sidebar.php';
?>
<?php include 'profile-common.php'; ?>
