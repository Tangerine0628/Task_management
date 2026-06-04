<?php
// Require auth, admin guard, and DB — then load the shared profile template
require_once '../../includes/session.php';
require_once '../../includes/guard.admin.php';
require_once '../../includes/conn.php';

// Point the profile template to the admin sidebar
$sidebar_path = '../../includes/sidebar.php';
?>
<?php include 'profile-common.php'; ?>
