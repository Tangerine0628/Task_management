<?php
// Require auth, user guard, DB connection, and activity logger
require_once '../../includes/session.php';
require_once '../../includes/guard.user.php';
require_once '../../includes/conn.php';
require_once '../../includes/task_activity.php';

// Get the logged-in user's ID for all queries below
$user_id = $currentUser['user_id'];

// ── Stat card counts for the current user ─────────────────────────────────────

// Total tasks assigned to this user
$my_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE assigned_to = $user_id");
$my_tasks = mysqli_fetch_assoc($my_tasks_result)['total'];

// Tasks this user has in progress
$my_ongoing_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE assigned_to = $user_id AND status = 'In Progress'");
$my_ongoing = mysqli_fetch_assoc($my_ongoing_result)['total'];

// Tasks this user has completed
$my_completed_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE assigned_to = $user_id AND status = 'Completed'");
$my_completed = mysqli_fetch_assoc($my_completed_result)['total'];

// Tasks past their due date that this user hasn't completed
$my_overdue_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE assigned_to = $user_id AND due_date < CURDATE() AND status != 'Completed'");
$my_overdue = mysqli_fetch_assoc($my_overdue_result)['total'];

// ── Fetch the user's task list sorted by urgency and priority ─────────────────
$my_tasks_list = mysqli_query($conn, "
  SELECT * FROM tbl_tasks 
  WHERE assigned_to = $user_id 
  ORDER BY 
    CASE WHEN due_date < CURDATE() AND status != 'Completed' THEN 0 ELSE 1 END,
    CASE priority WHEN 'High' THEN 0 WHEN 'Medium' THEN 1 ELSE 2 END,
    due_date ASC
");

// ── Handle inline status update submitted from the task table ─────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'], $_POST['new_status'])) {
    $task_id    = (int) $_POST['task_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
    $allowed    = ['In Progress', 'Completed'];

    if (in_array($new_status, $allowed)) {

        // Confirm the task belongs to this user before updating
        $check = mysqli_query($conn, "SELECT task_id, status FROM tbl_tasks WHERE task_id = $task_id AND assigned_to = $user_id");
        if (mysqli_num_rows($check) > 0) {
            $task_before = mysqli_fetch_assoc($check);

            // Apply the status update
            mysqli_query($conn, "UPDATE tbl_tasks SET status = '$new_status' WHERE task_id = $task_id");

            // Log the status change in the activity table
            record_task_activity(
                $conn,
                $task_id,
                $user_id,
                'status_changed',
                "Status changed from '" . $task_before['status'] . "' to '$new_status'."
            );
            header('Location: index2.php?updated=1');
        } else {
            header('Location: index2.php?error=1');
        }
    } else {
        // Reject any status value not in the allowed list
        header('Location: index2.php?error=1');
    }
    exit;
}
?>
<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Task Management System | My Dashboard</title>
    <?php include '../../includes/link.php'; ?>

    <style>
        /* ── Stat Cards (matches admin index.php) ── */
        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 20px 22px;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .stat-card p {
            margin: 0 0 4px;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.72;
        }

        .stat-card h4 {
            margin: 0;
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
        }

        /* Card colour themes */
        .stat-mytasks {
            background: linear-gradient(135deg, #e8f0fe 0%, #d2e3fc 100%);
        }

        .stat-mytasks .stat-icon {
            background: rgba(78, 115, 223, 0.15);
            color: #4e73df;
        }

        .stat-mytasks h4,
        .stat-mytasks p {
            color: #1e3a8a;
        }

        .stat-ongoing {
            background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
        }

        .stat-ongoing .stat-icon {
            background: rgba(255, 193, 7, 0.18);
            color: #f59e0b;
        }

        .stat-ongoing h4,
        .stat-ongoing p {
            color: #78350f;
        }

        .stat-done {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        }

        .stat-done .stat-icon {
            background: rgba(56, 176, 0, 0.15);
            color: #22c55e;
        }

        .stat-done h4,
        .stat-done p {
            color: #14532d;
        }

        .stat-overdue {
            background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
        }

        .stat-overdue .stat-icon {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .stat-overdue h4,
        .stat-overdue p {
            color: #7f1d1d;
        }

        /* ── Section Cards ── */
        .section-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .section-card .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 1.25rem 1.5rem !important;
        }

        .section-card .card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        /* ── View All Button ── */
        .btn-view-all {
            background: #4e73df;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 7px 15px;
            border-radius: 10px;
            transition: background 0.15s, transform 0.15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-view-all:hover {
            background: #3562c7;
            color: #fff;
            transform: translateY(-1px);
        }

        /* ── Priority badges ── */
        .badge-priority-high {
            background: #fff0f0;
            color: #e74a3b;
        }

        .badge-priority-medium {
            background: #fff8ec;
            color: #f6a609;
        }

        .badge-priority-low {
            background: #f0f4ff;
            color: #4e73df;
        }

        /* ── Status badges ── */
        .badge-status-progress {
            background: #eef2ff;
            color: #4e73df;
        }

        .badge-status-completed {
            background: #eafaf1;
            color: #1cc88a;
        }

        .badge-status-overdue {
            background: #fff0f0;
            color: #e74a3b;
        }

        .task-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        /* ── Task table ── */
        .task-table thead th {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6c757d;
            border-bottom: 2px solid #f0f0f0;
            padding: 10px 14px;
        }

        .task-table tbody td {
            padding: 10px 14px;
            font-size: 0.88rem;
            vertical-align: middle;
            border-bottom: 1px solid #f5f5f5;
        }

        .task-table tbody tr:last-child td {
            border-bottom: none;
        }

        .task-table tbody tr:hover td {
            background: #f4f7ff;
            transition: background 0.15s;
        }

        .row-overdue {
            background: #fffafa !important;
        }

        .row-overdue:hover {
            background: #fff0f0 !important;
        }

        /* ── Action buttons ── */
        .btn-update-status {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 6px;
            border: 1px solid #4e73df;
            background: transparent;
            color: #4e73df;
            transition: background 0.15s, color 0.15s;
            cursor: pointer;
        }

        .btn-act {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        }

        .btn-act:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .btn-act svg {
            width: 15px;
            height: 15px;
        }

        .btn-edit {
            background: #e8f0fe;
            color: #4e73df;
        }

        .btn-edit:hover {
            background: #4e73df;
            color: #fff;
        }

        .btn-details {
            background: #f3f4f6;
            color: #495057;
        }

        .btn-details:hover {
            background: #495057;
            color: #fff;
        }

        /* ── Task detail modal lists ── */
        .task-detail-list {
            max-height: 230px;
            overflow-y: auto;
        }

        .task-detail-item {
            padding-bottom: 12px;
            margin-bottom: 12px;
            border-bottom: 1px solid #f0f2f5;
        }

        .task-detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .task-detail-meta {
            font-size: 0.74rem;
            color: #adb5bd;
            margin-bottom: 4px;
        }

        .task-detail-text {
            font-size: 0.86rem;
            color: #343a40;
            margin: 0;
            line-height: 1.45;
            white-space: pre-wrap;
        }

        .task-detail-empty {
            color: #adb5bd;
            font-size: 0.84rem;
            text-align: center;
            padding: 22px 10px;
        }

        /* ── Empty state ── */
        .empty-tasks {
            padding: 48px 24px;
            text-align: center;
            color: #adb5bd;
        }

        .empty-tasks i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
        }

        /* ── Completion progress ── */
        .progress-bar-track {
            background: #e9ecef;
            border-radius: 20px;
            height: 8px;
            overflow: hidden;
        }

        /* ── Toast ── */
        .toast-notify {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-left: 4px solid #1cc88a;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 0.875rem;
            color: #212529;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 99999;
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .toast-notify.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-notify svg {
            width: 18px;
            height: 18px;
            color: #1cc88a;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>

    <?php
    $activePage = 'dashboard';
    include '../../includes/user-sidebar.php';
    ?>

    <main class="main-content">
        <div class="position-relative iq-banner">
            <?php include '../../includes/navbar.php'; ?>
            <div class="iq-navbar-header" style="height: 215px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h1>Welcome, <?php echo htmlspecialchars($currentUser['first_name'] ?? ''); ?>!</h1>
                                    <p>Here's an overview of your assigned tasks.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src="../../html/assets/images/dashboard/top-header.png" alt="header"
                        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div>
        </div>

        <div class="container-fluid content-inner mt-n5 py-0">

            <!-- Flash messages -->
            <?php if (isset($_GET['updated'])): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', () => showToast('Task status updated successfully!'));
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>
            <?php elseif (isset($_GET['error'])): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', () => showToast('Failed to update task status.'));
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>
            <?php endif; ?>

            <!-- ── STAT CARDS ── -->
            <div class="row row-cols-1 mb-4">
                <div class="overflow-hidden d-slider1">
                    <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">

                        <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="100">
                            <div class="stat-card stat-mytasks">
                                <div class="stat-icon"><i class="ti ti-clipboard-list"></i></div>
                                <div>
                                    <p>My Tasks</p>
                                    <h4><?php echo $my_tasks; ?></h4>
                                </div>
                            </div>
                        </li>

                        <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="200">
                            <div class="stat-card stat-ongoing">
                                <div class="stat-icon"><i class="ti ti-clock"></i></div>
                                <div>
                                    <p>In Progress</p>
                                    <h4><?php echo $my_ongoing; ?></h4>
                                </div>
                            </div>
                        </li>

                        <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="300">
                            <div class="stat-card stat-done">
                                <div class="stat-icon"><i class="ti ti-circle-check"></i></div>
                                <div>
                                    <p>Completed</p>
                                    <h4><?php echo $my_completed; ?></h4>
                                </div>
                            </div>
                        </li>

                        <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="400">
                            <div class="stat-card stat-overdue">
                                <div class="stat-icon"><i class="ti ti-alert-triangle"></i></div>
                                <div>
                                    <p>Overdue</p>
                                    <h4><?php echo $my_overdue; ?></h4>
                                </div>
                            </div>
                        </li>

                    </ul>
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
            <!-- END STAT CARDS -->

            <!-- ── TASK TABLE + RIGHT COLUMN ── -->
            <div class="row mt-2 mb-4">

                <!-- Task Table -->
                <div class="col-md-8 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header">
                            <div>
                                <h5 class="card-title">My Assigned Tasks</h5>
                                <p class="mb-0 text-muted" style="font-size:0.85rem;">Sorted by urgency and priority.
                                </p>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php if (mysqli_num_rows($my_tasks_list) === 0): ?>
                                <div class="empty-tasks">
                                    <i class="ti ti-mood-happy"></i>
                                    <p class="mb-0">No tasks assigned to you yet!</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table task-table mb-0 align-middle">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th class="ps-4">Task</th>
                                                <th>Priority</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th class="text-center pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($task = mysqli_fetch_assoc($my_tasks_list)):
                                                $is_overdue = (strtotime($task['due_date']) < strtotime(date('Y-m-d')) && $task['status'] !== 'Completed');
                                                $row_class = $is_overdue ? 'row-overdue' : '';

                                                $priority_class = match ($task['priority'] ?? 'Low') {
                                                    'High' => 'badge-priority-high',
                                                    'Medium' => 'badge-priority-medium',
                                                    default => 'badge-priority-low',
                                                };

                                                $status_class = match (true) {
                                                    $is_overdue => 'badge-status-overdue',
                                                    $task['status'] === 'Completed' => 'badge-status-completed',
                                                    default => 'badge-status-progress',
                                                };
                                                $status_label = $is_overdue ? 'Overdue' : $task['status'];
                                                ?>
                                                <tr class="<?php echo $row_class; ?>">
                                                    <td class="ps-4" style="max-width:220px;">
                                                        <span class="fw-semibold d-block text-truncate"
                                                            title="<?php echo htmlspecialchars($task['task_title'] ?? ''); ?>">
                                                            <?php echo htmlspecialchars($task['task_title'] ?? ''); ?>
                                                        </span>
                                                        <?php if (!empty($task['description'])): ?>
                                                            <small class="text-muted text-truncate d-block"
                                                                style="max-width:200px;">
                                                                <?php echo htmlspecialchars($task['description']); ?>
                                                            </small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="task-badge <?php echo $priority_class; ?>">
                                                            <?php echo htmlspecialchars($task['priority'] ?? 'Low'); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="<?php echo $is_overdue ? 'text-danger fw-semibold' : 'text-muted'; ?>">
                                                            <?php echo date('M j, Y', strtotime($task['due_date'])); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="task-badge <?php echo $status_class; ?>">
                                                            <?php echo $status_label; ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center pe-3">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button type="button" class="btn-act btn-details"
                                                                onclick="openTaskDetails(<?php echo (int) $task['task_id']; ?>, <?php echo htmlspecialchars(json_encode($task['task_title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>)">
                                                                <svg viewBox="0 0 24 24" fill="none">
                                                                    <path d="M12 5H12.01M12 12H12.01M12 19H12.01"
                                                                        stroke="currentColor" stroke-width="3"
                                                                        stroke-linecap="round" />
                                                                </svg>
                                                            </button>
                                                            <button type="button" class="btn-act btn-edit"
                                                                data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                                                data-task-id="<?php echo $task['task_id']; ?>"
                                                                data-task-title="<?php echo htmlspecialchars($task['task_title'] ?? ''); ?>"
                                                                data-task-status="<?php echo htmlspecialchars($task['status'] ?? ''); ?>">
                                                                <svg viewBox="0 0 24 24" fill="none">
                                                                    <path
                                                                        d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" />
                                                                    <path
                                                                        d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right column: doughnut + progress -->
                <div class="col-md-4 mb-4 d-flex flex-column gap-3">

                    <!-- Task Status Doughnut -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Task Status Overview</h5>
                            <p class="mb-0 text-muted" style="font-size:0.85rem;">Visual breakdown of your tasks.</p>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div style="width:220px;height:220px;position:relative;">
                                <canvas id="myTaskChart"></canvas>
                            </div>
                            <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:12px;height:12px;border-radius:3px;background:#4e73df;display:inline-block;"></span>
                                    <span class="text-muted small">In Progress</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:12px;height:12px;border-radius:3px;background:#1cc88a;display:inline-block;"></span>
                                    <span class="text-muted small">Completed</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:12px;height:12px;border-radius:3px;background:#e74a3b;display:inline-block;"></span>
                                    <span class="text-muted small">Overdue</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completion Progress -->
                    <div class="card section-card">
                        <div class="card-body">
                            <?php
                            $completion_pct = $my_tasks > 0 ? round(($my_completed / $my_tasks) * 100) : 0;
                            $progress_color = $completion_pct >= 75 ? '#1cc88a' : ($completion_pct >= 40 ? '#f6a609' : '#4e73df');
                            ?>
                            <h6 class="card-title mb-3">Completion Progress</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted" style="font-size:.8rem;">Tasks completed</span>
                                <span class="fw-semibold" style="font-size:.9rem;color:<?php echo $progress_color; ?>;">
                                    <?php echo $completion_pct; ?>%
                                </span>
                            </div>
                            <div class="progress-bar-track">
                                <div
                                    style="width:<?php echo $completion_pct; ?>%;background:<?php echo $progress_color; ?>;height:100%;border-radius:20px;transition:width .5s ease;">
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size:.75rem;">
                                <?php echo $my_completed; ?> of <?php echo $my_tasks; ?> tasks completed
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END TASK TABLE + CHART -->

        </div>

        <!-- ── UPDATE STATUS MODAL ── -->
        <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                <div class="modal-content"
                    style="border-radius:14px;border:none;box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-semibold" id="updateStatusModalLabel">
                            <i class="ti ti-edit me-2 text-primary"></i>Update Task Status
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="index2.php">
                        <div class="modal-body pt-2">
                            <p class="text-muted mb-1" style="font-size:.82rem;">Task</p>
                            <p class="fw-semibold text-dark mb-3" id="modalTaskTitle" style="font-size:.95rem;"></p>
                            <input type="hidden" name="task_id" id="modalTaskId">
                            <div class="mb-0">
                                <label class="form-label"
                                    style="font-size:.8rem;color:#8898aa;text-transform:uppercase;letter-spacing:.4px;font-weight:600;">New
                                    Status</label>
                                <select name="new_status" id="modalTaskStatusSelect" class="form-select form-select-sm">
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0 gap-2" style="background:transparent;">
                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary px-4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ── TASK DETAILS MODAL ── -->
        <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content"
                    style="border-radius:14px;border:none;box-shadow:0 8px 32px rgba(0,0,0,0.12);">
                    <div class="modal-header">
                        <h6 class="modal-title fw-semibold" id="taskDetailsTitle">Task Details</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="commentTaskId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h6 class="mb-3"
                                    style="font-size:.8rem;text-transform:uppercase;letter-spacing:.4px;color:#495057;">
                                    Comments</h6>
                                <div class="task-detail-list" id="taskCommentsList">
                                    <div class="task-detail-empty">Loading comments...</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3"
                                    style="font-size:.8rem;text-transform:uppercase;letter-spacing:.4px;color:#495057;">
                                    Activity</h6>
                                <div class="task-detail-list" id="taskActivityList">
                                    <div class="task-detail-empty">Loading activity...</div>
                                </div>
                            </div>
                        </div>
                        <form id="taskCommentForm" class="mt-3">
                            <textarea class="form-control" id="taskCommentText" placeholder="Add a comment..."
                                style="min-height:76px;"></textarea>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-sm btn-primary px-4">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../../includes/scripts.php'; ?>
        <?php include '../../includes/footer.php'; ?>
    </main>

    <!-- Toast -->
    <div class="toast-notify" id="toastNotify">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <span id="toastMsg">Task status updated successfully!</span>
    </div>

    <script>
        // Doughnut chart
        (function () {
            const ctx = document.getElementById('myTaskChart');
            if (!ctx) return;

            const ongoing = <?php echo $my_ongoing; ?>;
            const completed = <?php echo $my_completed; ?>;
            const overdue = <?php echo $my_overdue; ?>;
            const total = ongoing + completed + overdue || 1;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['In Progress', 'Completed', 'Overdue'],
                    datasets: [{
                        data: [ongoing, completed, overdue],
                        backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
                        borderColor: ['#fff', '#fff', '#fff'],
                        borderWidth: 3,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const val = ctx.parsed;
                                    const pct = ((val / total) * 100).toFixed(1);
                                    return ` ${ctx.label}: ${val} tasks (${pct}%)`;
                                }
                            }
                        }
                    }
                },
                plugins: [{
                    id: 'centerText',
                    beforeDraw(chart) {
                        const { ctx, chartArea: { width, height, left, top } } = chart;
                        ctx.save();
                        ctx.font = 'bold 28px sans-serif';
                        ctx.fillStyle = '#1e3a8a';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(total, left + width / 2, top + height / 2 - 10);
                        ctx.font = '600 12px sans-serif';
                        ctx.fillStyle = '#6c757d';
                        ctx.fillText('My Tasks', left + width / 2, top + height / 2 + 16);
                        ctx.restore();
                    }
                }]
            });
        })();

        // Modal population
        document.getElementById('updateStatusModal').addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            document.getElementById('modalTaskId').value = btn.dataset.taskId;
            document.getElementById('modalTaskTitle').textContent = btn.dataset.taskTitle;
            document.getElementById('modalTaskStatusSelect').value = btn.dataset.taskStatus === 'Completed' ? 'Completed' : 'In Progress';
        });

        function showToast(msg) {
            const toast = document.getElementById('toastNotify');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function escapeHtml(str) {
            return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function formatDateTime(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr.replace(' ', 'T'));
            if (Number.isNaN(d.getTime())) return dateStr;
            return d.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
        }

        function activityLabel(action) {
            const labels = {
                task_created: 'Task created',
                task_updated: 'Task updated',
                task_deleted: 'Task deleted',
                status_changed: 'Status changed',
                comment_added: 'Comment added'
            };
            return labels[action] || String(action).replace(/_/g, ' ');
        }

        function openTaskDetails(taskId, taskTitle) {
            document.getElementById('commentTaskId').value = taskId;
            document.getElementById('taskDetailsTitle').textContent = taskTitle || 'Task Details';
            document.getElementById('taskCommentText').value = '';
            document.getElementById('taskCommentsList').innerHTML = '<div class="task-detail-empty">Loading comments...</div>';
            document.getElementById('taskActivityList').innerHTML = '<div class="task-detail-empty">Loading activity...</div>';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('taskDetailsModal')).show();
            loadTaskDetails(taskId);
        }

        function renderTaskDetails(data) {
            const commentsList = document.getElementById('taskCommentsList');
            const activityList = document.getElementById('taskActivityList');

            commentsList.innerHTML = data.comments.length ? data.comments.map(c => `
                <div class="task-detail-item">
                    <div class="task-detail-meta">${escapeHtml(c.author_name || 'Unknown user')} &bull; ${formatDateTime(c.created_at)}</div>
                    <p class="task-detail-text">${escapeHtml(c.comment)}</p>
                </div>
            `).join('') : '<div class="task-detail-empty">No comments yet.</div>';

            activityList.innerHTML = data.activity.length ? data.activity.map(item => `
                <div class="task-detail-item">
                    <div class="task-detail-meta">${escapeHtml(item.actor_name || 'System')} &bull; ${formatDateTime(item.created_at)}</div>
                    <p class="task-detail-text"><strong>${escapeHtml(activityLabel(item.action))}</strong>${item.details ? ': ' + escapeHtml(item.details) : ''}</p>
                </div>
            `).join('') : '<div class="task-detail-empty">No activity yet.</div>';
        }

        function loadTaskDetails(taskId) {
            fetch('../tasks/tasksData/ctrl.get.task.details.php?task_id=' + encodeURIComponent(taskId))
                .then(res => res.json())
                .then(data => {
                    if (!data.success) { showToast(data.message || 'Could not load task details.'); return; }
                    renderTaskDetails(data);
                })
                .catch(() => showToast('Could not load task details.'));
        }

        document.getElementById('taskCommentForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const taskId = document.getElementById('commentTaskId').value;
            const commentText = document.getElementById('taskCommentText').value.trim();
            if (!commentText) { document.getElementById('taskCommentText').focus(); return; }

            const formData = new FormData();
            formData.append('task_id', taskId);
            formData.append('comment', commentText);

            fetch('../tasks/tasksData/ctrl.add.comment.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) { showToast(data.message || 'Could not save comment.'); return; }
                    document.getElementById('taskCommentText').value = '';
                    showToast('Comment added.');
                    loadTaskDetails(taskId);
                })
                .catch(() => showToast('Could not save comment.'));
        });
    </script>

</body>

</html>