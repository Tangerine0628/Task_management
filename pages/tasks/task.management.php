<?php
require_once '../../includes/session.php';
require_once '../../includes/guard.admin.php';
include '../../includes/conn.php';
include '../../includes/task_activity.php';


$tasks_per_page = 5;

$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($current_page < 1) {
  $current_page = 1;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_safe = mysqli_real_escape_string($conn, $search);
$priority_filter = isset($_GET['priority']) ? mysqli_real_escape_string($conn, $_GET['priority']) : '';
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$sort_filter = isset($_GET['sort']) ? $_GET['sort'] : '';

$conditions = [];
if ($search_safe !== "") {
  $conditions[] = "(tbl_tasks.task_title LIKE '%$search_safe%' 
        OR tbl_tasks.description LIKE '%$search_safe%'
        OR tbl_users.first_name LIKE '%$search_safe%'
        OR tbl_users.last_name LIKE '%$search_safe%'
        OR tbl_tasks.priority LIKE '%$search_safe%'
        OR tbl_tasks.status LIKE '%$search_safe%')";
}
if ($priority_filter !== '')
  $conditions[] = "tbl_tasks.priority = '$priority_filter'";
if ($status_filter !== '')
  $conditions[] = "tbl_tasks.status = '$status_filter'";

$where_clause = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

$order_clause = "ORDER BY tbl_tasks.created_at DESC";
if ($sort_filter === 'due_asc')
  $order_clause = "ORDER BY tbl_tasks.due_date ASC";
if ($sort_filter === 'due_desc')
  $order_clause = "ORDER BY tbl_tasks.due_date DESC";

$query_string = http_build_query(array_filter([
  'search' => $search,
  'priority' => $priority_filter,
  'status' => $status_filter,
  'sort' => $sort_filter,
]));

$search_query = $query_string ? "&$query_string" : "";

$offset = ($current_page - 1) * $tasks_per_page;

$total_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total 
  FROM tbl_tasks
  LEFT JOIN tbl_users ON tbl_tasks.assigned_to = tbl_users.user_id
  $where_clause");
$total_tasks = mysqli_fetch_assoc($total_tasks_result)['total'];

$total_pages = ceil($total_tasks / $tasks_per_page);
?>

<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Taskflow | Task Management</title>

  <!-- Links -->
  <?php include '../../includes/link.php'; ?>

  <style>
    .sidebar-toggle {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      border-radius: 10px !important;
      transition: background 0.2s, color 0.2s !important;
      color: #94a3b8 !important;
      /* visible grey by default */
    }

    .sidebar-toggle:hover {
      background: rgba(78, 115, 223, 0.1) !important;
      color: #4e73df !important;
      /* turns blue on hover */
    }

    .btn-delete-selected {
      position: relative;
      z-index: 2;
    }

    .btn-delete-selected {
      padding: 8px 16px;
      border: 1px solid #d63031;
      border-radius: 8px;
      background: #fff0f0;
      color: #d63031;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.15s;
    }

    .btn-delete-selected:hover:not(:disabled) {
      background: #d63031;
      color: #fff;
    }

    .btn-delete-selected:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }

    /* ── Add Task Button ── */
    .btn-add-task {
      background: linear-gradient(135deg, #4e73df 0%, #2b7de0 100%);
      color: #fff;
      border: none;
      padding: 10px 22px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.92rem;
      letter-spacing: 0.3px;
      box-shadow: 0 4px 15px rgba(78, 115, 223, 0.38);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
      text-decoration: none;
    }

    .btn-add-task:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(78, 115, 223, 0.52);
      color: #fff;
    }

    .btn-add-task svg {
      width: 16px;
      height: 16px;
    }

    /* ── Task Table Card ── */
    .task-table-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
    }

    .task-table th:nth-child(2),
    .task-table td:nth-child(2) {
      max-width: 200px;
      word-break: break-word;
      overflow: hidden;
    }

    .task-desc {
      font-size: 0.78rem;
      color: #adb5bd;
      margin: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px;
    }

    /* ── Toolbar ── */
    .table-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid #f0f2f5;
      gap: 12px;
      flex-wrap: wrap;
    }

    .table-toolbar-title {
      font-size: 1rem;
      font-weight: 700;
      color: #212529;
      margin: 0;
    }

    .toolbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      position: relative;
      z-index: 10;
    }

    .toolbar-right .form-select {
      position: relative;
      z-index: 10;
      cursor: pointer;
      appearance: auto;
      -webkit-appearance: auto;
    }

    .table-toolbar-search {
      position: relative;
    }

    .table-toolbar-search input {
      padding: 8px 12px 8px 34px;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      font-size: 0.85rem;
      outline: none;
      width: 220px;
      transition: border-color 0.2s;
      background: #f8f9fa;
    }

    .table-toolbar-search input:focus {
      border-color: #4e73df;
      background: #fff;
    }

    .table-toolbar-search svg {
      position: absolute;
      left: 9px;
      top: 50%;
      transform: translateY(-50%);
      color: #adb5bd;
      width: 15px;
      height: 15px;
    }

    /* ── Table ── */
    .task-table {
      width: 100%;
      border-collapse: collapse;
    }

    .task-table thead th {
      background: #f8f9fa;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: #6c757d;
      border-bottom: 2px solid #e9ecef;
      padding: 13px 16px;
      white-space: nowrap;
    }

    .task-table tbody td {
      padding: 13px 16px;
      vertical-align: middle;
      border-bottom: 1px solid #f0f2f5;
      font-size: 0.875rem;
      color: #343a40;
    }

    .task-table tbody tr:last-child td {
      border-bottom: none;
    }

    .task-table tbody tr:hover {
      background: #f8f9ff;
    }

    .task-title {
      font-weight: 600;
      color: #212529;
      margin: 0 0 2px;
    }

    .task-desc {
      font-size: 0.78rem;
      color: #adb5bd;
      margin: 0;
    }

    /* ── Badges ── */
    .badge-pill {
      padding: 4px 11px;
      border-radius: 20px;
      font-size: 0.73rem;
      font-weight: 600;
      display: inline-block;
    }

    .badge-high {
      background: #fff0f0;
      color: #d63031;
    }

    .badge-medium {
      background: #fff8e1;
      color: #e67e22;
    }

    .badge-low {
      background: #e8f8f0;
      color: #27ae60;
    }

    .badge-progress {
      background: #e8f0fe;
      color: #4e73df;
    }

    .badge-done {
      background: #e8f8f0;
      color: #27ae60;
    }

    .badge-pending {
      background: #f3f4f6;
      color: #6c757d;
    }

    /* ── Avatar ── */
    .avatar-sm {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    /* ── Action Buttons ── */
    .btn-act {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      border: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
      font-size: 0;
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

    .btn-delete {
      background: #fff0f0;
      color: #d63031;
    }

    .btn-delete:hover {
      background: #d63031;
      color: #fff;
    }

    /* ── Due date colours ── */
    .due-overdue {
      color: #d63031;
      font-weight: 600;
    }

    .due-soon {
      color: #e67e22;
      font-weight: 600;
    }

    .due-ok {
      color: #495057;
    }

    /* ── Pagination ── */
    .table-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 13px 20px;
      border-top: 1px solid #f0f2f5;
      font-size: 0.83rem;
      color: #6c757d;
      flex-wrap: wrap;
      gap: 8px;
    }

    .page-btns {
      display: flex;
      gap: 4px;
    }

    .page-btn {
      width: 32px;
      height: 32px;
      border-radius: 7px;
      border: 1px solid #e9ecef;
      background: #fff;
      font-size: 0.82rem;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #495057;
      transition: background 0.15s, color 0.15s;
    }

    .page-btn.active,
    .page-btn:hover {
      background: #4e73df;
      color: #fff;
      border-color: #4e73df;
    }

    .gap-2 {
      gap: 0.5rem !important;
    }

    /* ── Modal Overlay ── */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 9999;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .modal-overlay.active {
      display: flex;
    }

    /* ── Modal Card ── */
    .modal-card {
      background: #fff;
      border-radius: 14px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
      animation: modalIn 0.2s ease;
      overflow: hidden;
    }

    @keyframes modalIn {
      from {
        opacity: 0;
        transform: translateY(-18px) scale(0.97);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.1rem 1.35rem 0.9rem;
      border-bottom: 1px solid #f0f2f5;
    }

    .modal-header-title {
      font-size: 1rem;
      font-weight: 700;
      color: #212529;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .modal-header-title svg {
      width: 18px;
      height: 18px;
      color: #4e73df;
    }

    .modal-close {
      width: 32px;
      height: 32px;
      border-radius: 7px;
      border: none;
      background: #f8f9fa;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #6c757d;
      transition: background 0.15s;
    }

    .modal-close:hover {
      background: #e9ecef;
      color: #212529;
    }

    .modal-close svg {
      width: 16px;
      height: 16px;
    }

    .modal-body {
      padding: 1.35rem;
    }

    /* ── Form Fields ── */
    .form-field {
      margin-bottom: 1rem;
    }

    .form-field:last-child {
      margin-bottom: 0;
    }

    .form-label {
      display: block;
      font-size: 0.8rem;
      font-weight: 600;
      color: #495057;
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    .form-label .optional {
      font-weight: 400;
      color: #adb5bd;
      text-transform: none;
      letter-spacing: 0;
      font-size: 0.78rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
      width: 100%;
      box-sizing: border-box;
      padding: 9px 12px;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      font-size: 0.875rem;
      color: #343a40;
      background: #f8f9fa;
      outline: none;
      transition: border-color 0.2s, background 0.2s;
      font-family: inherit;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      border-color: #4e73df;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }

    .form-input.error {
      border-color: #d63031;
      box-shadow: 0 0 0 3px rgba(214, 48, 49, 0.1);
    }

    .form-textarea {
      resize: none;
      height: 78px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .modal-footer {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 8px;
      padding: 0.9rem 1.35rem;
      border-top: 1px solid #f0f2f5;
      background: #fafbfc;
    }

    .btn-cancel-modal {
      padding: 9px 20px;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      background: #fff;
      font-size: 0.875rem;
      color: #6c757d;
      cursor: pointer;
      font-weight: 500;
      transition: background 0.15s;
    }

    .btn-cancel-modal:hover {
      background: #f8f9fa;
    }

    /* Add Task modal submit — blue */
    .btn-submit-modal {
      padding: 9px 22px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(135deg, #4e73df 0%, #2b7de0 100%);
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(78, 115, 223, 0.35);
      transition: transform 0.15s, box-shadow 0.15s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-submit-modal:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(78, 115, 223, 0.45);
    }

    .btn-submit-modal svg {
      width: 15px;
      height: 15px;
    }

    /* Edit modal submit — green */
    .btn-submit-edit {
      padding: 9px 22px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(28, 200, 138, 0.35);
      transition: transform 0.15s, box-shadow 0.15s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-submit-edit:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(28, 200, 138, 0.45);
    }

    .btn-submit-edit svg {
      width: 15px;
      height: 15px;
    }

    .modal-header-title.edit-accent svg {
      color: #1cc88a;
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

    .task-detail-modal {
      max-width: 760px;
    }

    .task-detail-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
    }

    .task-detail-panel {
      border: 1px solid #f0f2f5;
      border-radius: 10px;
      overflow: hidden;
      background: #fff;
    }

    .task-detail-panel-header {
      padding: 11px 14px;
      border-bottom: 1px solid #f0f2f5;
      background: #fafbfc;
      font-size: 0.82rem;
      font-weight: 700;
      color: #343a40;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    .task-detail-list {
      max-height: 280px;
      overflow-y: auto;
      padding: 12px 14px;
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
      padding: 24px 10px;
    }

    .task-comment-form {
      margin-top: 16px;
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }

    .task-comment-form textarea {
      min-height: 70px;
    }

    @media (max-width: 768px) {
      .task-detail-grid {
        grid-template-columns: 1fr;
      }

      .task-comment-form {
        flex-direction: column;
      }
    }
  </style>
</head>

<body class="">
  <!-- loader -->
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>

  <!-- ── Sidebar ── -->
  <?php
  $activePage = 'tasks';
  include '../../includes/sidebar.php';
  ?>

  <!-- ── Main ── -->
  <main class="main-content">
    <div class="position-relative iq-banner">

      <!-- Navbar -->
      <?php include '../../includes/navbar.php'; ?>

      <!-- Page Header -->
      <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                  <h1>Task Management</h1>
                  <p>Create, assign, and track tasks across your team.</p>
                </div>
                <div>
                  <button class="btn-add-task" onclick="openModal()">
                    <svg viewBox="0 0 24 24" fill="none">
                      <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                    Add Task
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="iq-header-img">
          <img src="../../html/assets/images/dashboard/top-header.png" alt="header"
            class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
          <img src="../../html/assets/images/dashboard/top-header1.png" alt="header"
            class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
          <img src="../../html/assets/images/dashboard/top-header2.png" alt="header"
            class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
        </div>
      </div>

    </div>

    <!-- ── Content ── -->
    <div class="container-fluid content-inner mt-n5 py-0">
      <div class="row">
        <div class="col-12">
          <div class="task-table-card">

            <!-- Toolbar -->
            <div class="table-toolbar">
              <h6 class="table-toolbar-title">All Tasks</h6>
              <div class="toolbar-right">
                <button type="submit" name="delete_selected" form="bulkDeleteForm" class="btn-delete-selected"
                  id="deleteSelectedBtn" disabled>
                  Delete Selected
                </button>
                <select class="form-select" id="filterPriority" onchange="applyFilters()"
                  style="width:130px; padding:8px 12px; font-size:0.85rem;">
                  <option value="">All Priorities</option>
                  <option value="High" <?php echo (isset($_GET['priority']) && $_GET['priority'] === 'High') ? 'selected' : ''; ?>>High</option>
                  <option value="Medium" <?php echo (isset($_GET['priority']) && $_GET['priority'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
                  <option value="Low" <?php echo (isset($_GET['priority']) && $_GET['priority'] === 'Low') ? 'selected' : ''; ?>>Low</option>
                </select>

                <select class="form-select" id="filterStatus" onchange="applyFilters()"
                  style="width:130px; padding:8px 12px; font-size:0.85rem;">
                  <option value="">All Statuses</option>
                  <option value="In Progress" <?php echo (isset($_GET['status']) && $_GET['status'] === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                  <option value="Completed" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                </select>

                <select class="form-select" id="filterSort" onchange="applyFilters()"
                  style="width:140px; padding:8px 12px; font-size:0.85rem;">
                  <option value="">Sort: Default</option>
                  <option value="due_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'due_asc') ? 'selected' : ''; ?>>Due Date ↑</option>
                  <option value="due_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'due_desc') ? 'selected' : ''; ?>>Due Date ↓</option>
                </select>
                <form method="GET" class="table-toolbar-search">
                  <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    <path d="M17 17L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                  </svg>
                  <input type="text" name="search" id="searchInput" placeholder="Search tasks..."
                    value="<?php echo htmlspecialchars($search); ?>">
                </form>
              </div>
            </div>

            <!-- Table -->
            <form method="POST" action="tasksData/ctrl.bulk.delete.task.php" id="bulkDeleteForm">
              <div style="overflow-x: auto;">
                <table class="task-table" id="taskTable">
                  <thead>
                    <tr>
                      <th style="width:42px; text-align:center;">
                        <input type="checkbox" id="selectAllTasks">
                      </th>
                      <th>Task</th>
                      <th>Assignee</th>
                      <th>Priority</th>
                      <th>Status</th>
                      <th>Due Date</th>
                      <th style="text-align:center;">Actions</th>
                    </tr>
                  </thead>
                  <tbody id="taskTableBody">
                    <?php
                    $select_tasks = mysqli_query($conn, "SELECT tbl_tasks.*, CONCAT(tbl_users.first_name, ' ', tbl_users.last_name) AS assignee_name 
  FROM tbl_tasks 
  LEFT JOIN tbl_users ON tbl_tasks.assigned_to = tbl_users.user_id
  $where_clause
  $order_clause
  LIMIT $tasks_per_page OFFSET $offset");
                    $task_count = mysqli_num_rows($select_tasks);
                    if ($task_count == 0) { ?>
                      <tr id="emptyRow">
                        <td colspan="7" style="text-align:center; padding: 40px; color: #adb5bd; font-size: 0.9rem;">
                          No tasks found. Click <strong>Add Task</strong> to get started.
                        </td>
                      </tr>
                    <?php } else {
                      while ($row = mysqli_fetch_array($select_tasks)) { ?>
                        <tr>
                          <td style="text-align:center;">
                            <input type="checkbox" class="task-checkbox" name="task_ids[]"
                              value="<?php echo $row['task_id']; ?>">
                          </td>
                          <td>
                            <p class="task-title"><?php echo $row['task_title']; ?></p>
                            <?php if ($row['description']) { ?>
                              <p class="task-desc"><?php echo $row['description']; ?></p>
                            <?php } ?>
                          </td>
                          <td><?php echo $row['assignee_name'] ?? '<span style="color:#adb5bd;">Unassigned</span>'; ?></td>
                          <td>
                            <?php if ($row['priority']) { ?>
                              <span
                                class="badge-pill badge-<?php echo strtolower($row['priority']); ?>"><?php echo $row['priority']; ?></span>
                            <?php } else {
                              echo '<span style="color:#adb5bd;">—</span>';
                            } ?>
                          </td>
                          <td>
                            <span
                              class="badge-pill <?php echo $row['status'] == 'In Progress' ? 'badge-progress' : 'badge-done'; ?>">
                              <?php echo $row['status']; ?>
                            </span>
                          </td>
                          <td><?php echo $row['due_date'] ? date('M d, Y', strtotime($row['due_date'])) : '—'; ?></td>
                          <td style="text-align:center;">
                            <div class="d-flex justify-content-center gap-2">
                              <button type="button" class="btn-act btn-details" title="Details"
                                onclick="openTaskDetails(<?php echo (int) $row['task_id']; ?>, <?php echo htmlspecialchars(json_encode($row['task_title']), ENT_QUOTES, 'UTF-8'); ?>)">
                                <svg viewBox="0 0 24 24" fill="none">
                                  <path d="M12 5H12.01M12 12H12.01M12 19H12.01" stroke="currentColor" stroke-width="3"
                                    stroke-linecap="round" />
                                </svg>
                              </button>
                              <button type="button" class="btn-act btn-edit" title="Edit" onclick="openEditModal(
  '<?php echo $row['task_id']; ?>',
  '<?php echo addslashes($row['task_title']); ?>',
  '<?php echo addslashes($row['description']); ?>',
  '<?php echo $row['assigned_to']; ?>',
  '<?php echo $row['due_date']; ?>',
  '<?php echo $row['priority']; ?>',
  '<?php echo $row['status']; ?>'
)">
                                <svg viewBox="0 0 24 24" fill="none">
                                  <path
                                    d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                  <path
                                    d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                              </button>
                              <button type="button" class="btn-act btn-delete" title="Delete"
                                onclick="openDeleteModal('<?php echo $row['task_id']; ?>', '<?php echo addslashes($row['task_title']); ?>')">
                                <svg viewBox="0 0 24 24" fill="none">
                                  <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                  <path
                                    d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                              </button>

                            </div>
                          </td>
                        </tr>
                      <?php }
                    } ?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination Footer -->
              <div class="table-footer">
                <span id="taskCount">Showing 0 tasks</span>
                <div class="page-btns">
                  <?php if ($current_page > 1) { ?>
                    <a class="page-btn" href="?page=<?php echo $current_page - 1 . $search_query; ?>">&#8249;</a>
                  <?php } ?>

                  <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <a class="page-btn <?php echo $i == $current_page ? 'active' : ''; ?>"
                      href="?page=<?php echo $i . $search_query; ?>">
                      <?php echo $i; ?>
                    </a>
                  <?php } ?>

                  <?php if ($current_page < $total_pages) { ?>
                    <a class="page-btn" href="?page=<?php echo $current_page + 1 . $search_query; ?>">&#8250;</a>
                  <?php } ?>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-body">
        <ul class="left-panel list-inline mb-0 p-0">
          <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
          <li class="list-inline-item"><a href="#">Terms of Use</a></li>
        </ul>
        <div class="right-panel">
          &copy;
          <script>document.write(new Date().getFullYear())</script> TaskFlow. All rights reserved.
        </div>
      </div>
    </footer>
  </main>

  <!-- ══════════════════════════════════
       ADD TASK MODAL
  ══════════════════════════════════ -->
  <div class="modal-overlay" id="addTaskModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-card">
      <div class="modal-header">
        <p class="modal-header-title" id="modalTitle">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          Add New Task
        </p>
        <button type="button" class="modal-close" onclick="closeModal()" aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <form method="POST" action="tasksData/ctrl.add.task.php">
        <div class="modal-body">
          <div class="form-field">
            <label class="form-label" for="taskTitle">Task Title <span style="color:#d63031;">*</span></label>
            <input class="form-input" type="text" name="task_title" id="taskTitle" placeholder="Enter task title"
              autocomplete="off" required>
            <span id="titleError" style="display:none;font-size:0.78rem;color:#d63031;margin-top:4px;">Please enter a
              task title.</span>
          </div>
          <div class="form-field">
            <label class="form-label" for="taskDesc">Description <span class="optional">(optional)</span></label>
            <textarea class="form-textarea" name="description" id="taskDesc"
              placeholder="Add a short description..."></textarea>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="form-label" for="taskAssignee">Assignee</label>
              <select class="form-select" name="assigned_to" id="taskAssignee" required>
                <option value="">— Select User —</option>
                <?php
                $users = mysqli_query($conn, "SELECT user_id, first_name, last_name FROM tbl_users");
                while ($u = mysqli_fetch_array($users)) {
                  echo "<option value='" . $u['user_id'] . "'>" . $u['first_name'] . " " . $u['last_name'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-field">
              <label class="form-label" for="taskDue">Due Date</label>
              <input class="form-input" type="date" name="due_date" id="taskDue" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="form-label" for="taskPriority">Priority</label>
              <select class="form-select" name="priority" id="taskPriority" required>
                <option value="">— Select —</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
            </div>
            <div class="form-field">
              <label class="form-label" for="taskStatus">Status</label>
              <select class="form-select" name="status" id="taskStatus">
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel-modal" onclick="closeModal()">Cancel</button>
          <button type="submit" name="button" class="btn-submit-modal">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Add Task
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ══════════════════════════════════
       EDIT TASK MODAL
  ══════════════════════════════════ -->
  <div class="modal-overlay" id="editTaskModal" role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
    <div class="modal-card">
      <div class="modal-header">
        <p class="modal-header-title edit-accent" id="editModalTitle">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Edit Task
        </p>
        <button type="button" class="modal-close" onclick="closeEditModal()" aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <form method="POST" action="tasksData/ctrl.edit.task.php">
        <input type="hidden" name="task_id" id="editTaskId">
        <div class="modal-body">
          <div class="form-field">
            <label class="form-label" for="editTitle">Task Title <span style="color:#d63031;">*</span></label>
            <input class="form-input" type="text" name="task_title" id="editTitle" autocomplete="off">
            <span id="editTitleError" style="display:none;font-size:0.78rem;color:#d63031;margin-top:4px;">Please enter
              a task title.</span>
          </div>
          <div class="form-field">
            <label class="form-label" for="editDesc">Description <span class="optional">(optional)</span></label>
            <textarea class="form-textarea" name="description" id="editDesc"
              placeholder="Add a short description..."></textarea>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="form-label" for="editAssignee">Assignee</label>
              <select class="form-select" name="assigned_to" id="editAssignee">
                <option value="">— Select User —</option>
                <?php
                $users2 = mysqli_query($conn, "SELECT user_id, first_name, last_name FROM tbl_users");
                while ($u = mysqli_fetch_array($users2)) {
                  echo "<option value='" . $u['user_id'] . "'>" . $u['first_name'] . " " . $u['last_name'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-field">
              <label class="form-label" for="editDue">Due Date</label>
              <input class="form-input" type="date" name="due_date" id="editDue">
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="form-label" for="editPriority">Priority</label>
              <select class="form-select" name="priority" id="editPriority">
                <option value="">— Select —</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
            </div>
            <div class="form-field">
              <label class="form-label" for="editStatus">Status</label>
              <select class="form-select" name="status" id="editStatus">
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel-modal" onclick="closeEditModal()">Cancel</button>
          <button type="submit" name="button" class="btn-submit-edit">
            <svg viewBox="0 0 24 24" fill="none">
              <path
                d="M19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H16L21 8V19C21 20.1046 20.1046 21 19 21Z"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M17 21V13H7V21M7 3V8H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- TASK DETAILS MODAL -->
  <div class="modal-overlay" id="taskDetailsModal" role="dialog" aria-modal="true">
    <div class="modal-card task-detail-modal">
      <div class="modal-header">
        <p class="modal-header-title">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M8 6H21M8 12H21M8 18H21M3 6H3.01M3 12H3.01M3 18H3.01" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" />
          </svg>
          <span id="taskDetailsTitle">Task Details</span>
        </p>
        <button type="button" class="modal-close" onclick="closeTaskDetails()">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="commentTaskId">
        <div class="task-detail-grid">
          <div class="task-detail-panel">
            <div class="task-detail-panel-header">Comments</div>
            <div class="task-detail-list" id="taskCommentsList">
              <div class="task-detail-empty">Loading comments...</div>
            </div>
          </div>
          <div class="task-detail-panel">
            <div class="task-detail-panel-header">Activity</div>
            <div class="task-detail-list" id="taskActivityList">
              <div class="task-detail-empty">Loading activity...</div>
            </div>
          </div>
        </div>
        <form class="task-comment-form" id="taskCommentForm">
          <textarea class="form-textarea" id="taskCommentText" name="comment" placeholder="Add a comment..."></textarea>
          <button type="submit" class="btn-submit-modal">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Comment
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- DELETE TASK MODAL -->
  <div class="modal-overlay" id="deleteTaskModal" role="dialog" aria-modal="true">
    <div class="modal-card" style="max-width:380px;">
      <div class="modal-header">
        <p class="modal-header-title" style="color:#d63031;">
          <svg viewBox="0 0 24 24" fill="none" style="width:18px;height:18px;color:#d63031;">
            <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path
              d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Delete Task
        </p>
        <button type="button" class="modal-close" onclick="closeDeleteModal()">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <form method="GET" action="tasksData/ctrl.delete.task.php">
        <input type="hidden" name="task_id" id="deleteTaskId">
        <div class="modal-body" style="text-align:center;">
          <svg viewBox="0 0 24 24" fill="none" style="width:44px;height:44px;color:#d63031;margin-bottom:12px;">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          <p style="font-size:0.9rem;color:#495057;">Are you sure you want to delete <strong
              id="deleteTaskName"></strong>? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel-modal" onclick="closeDeleteModal()">Cancel</button>
          <button type="submit" class="btn-submit-modal"
            style="background:linear-gradient(135deg,#d63031,#c0392b);box-shadow:0 4px 12px rgba(214,48,49,0.35);">
            <svg viewBox="0 0 24 24" fill="none" style="width:15px;height:15px;">
              <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path
                d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Yes, Delete
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- BULK DELETE MODAL -->
  <div class="modal-overlay" id="bulkDeleteModal" role="dialog" aria-modal="true">
    <div class="modal-card" style="max-width:380px;">
      <div class="modal-header">
        <p class="modal-header-title" style="color:#d63031;">
          <svg viewBox="0 0 24 24" fill="none" style="width:18px;height:18px;color:#d63031;">
            <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path
              d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Delete Selected Tasks
        </p>
        <button type="button" class="modal-close" onclick="closeBulkDeleteModal()">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <div class="modal-body" style="text-align:center;">
        <svg viewBox="0 0 24 24" fill="none" style="width:44px;height:44px;color:#d63031;margin-bottom:12px;">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <p style="font-size:0.9rem;color:#495057;">Are you sure you want to delete <strong
            id="bulkDeleteCount"></strong> selected task(s)? This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel-modal" onclick="closeBulkDeleteModal()">Cancel</button>
        <button type="button" id="bulkDeleteConfirmBtn" class="btn-submit-modal"
          style="background:linear-gradient(135deg,#d63031,#c0392b);box-shadow:0 4px 12px rgba(214,48,49,0.35);">
          <svg viewBox="0 0 24 24" fill="none" style="width:15px;height:15px;">
            <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path
              d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Yes, Delete
        </button>
      </div>
    </div>
  </div>



  <!-- Toast -->
  <div class="toast-notify" id="toastNotify">
    <svg viewBox="0 0 24 24" fill="none">
      <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
        stroke-linejoin="round" />
    </svg>
    <span id="toastMsg">Task added successfully!</span>
  </div>

  <!-- Scripts -->
  <?php include '../../includes/scripts.php'; ?>
  <script>
    /* ── Helpers ── */
    function priorityClass(p) {
      if (p === 'High') return 'badge-high';
      if (p === 'Medium') return 'badge-medium';
      if (p === 'Low') return 'badge-low';
      return 'badge-pending';
    }
    function statusClass(s) {
      if (s === 'In Progress') return 'badge-progress';
      if (s === 'Completed') return 'badge-done';
      return 'badge-pending';
    }
    function formatDate(dateStr) {
      if (!dateStr) return '<span class="due-ok">—</span>';
      const d = new Date(dateStr + 'T00:00:00');
      const today = new Date(); today.setHours(0, 0, 0, 0);
      const diff = (d - today) / (1000 * 60 * 60 * 24);
      const label = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
      if (diff < 0) return '<span class="due-overdue">' + label + '</span>';
      if (diff <= 7) return '<span class="due-soon">' + label + '</span>';
      return '<span class="due-ok">' + label + '</span>';
    }
    function escapeHtml(str) {
      return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function showToast(msg) {
      const toast = document.getElementById('toastNotify');
      document.getElementById('toastMsg').textContent = msg;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3000);
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
    function updateCount() {
      const rows = document.getElementById('taskTableBody').querySelectorAll('tr:not(#emptyRow)').length;
      document.getElementById('taskCount').textContent = 'Showing ' + rows + ' task' + (rows !== 1 ? 's' : '');

      const emptyRow = document.getElementById('emptyRow');
      if (emptyRow) {
        emptyRow.style.display = rows === 0 ? '' : 'none';
      }
    }
    function filterTable() {
      const query = document.getElementById('searchInput').value.toLowerCase();
      document.querySelectorAll('#taskTableBody tr:not(#emptyRow)').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
      });
    }

    let activeDetailsTaskId = null;

    function openTaskDetails(taskId, taskTitle) {
      activeDetailsTaskId = taskId;
      document.getElementById('commentTaskId').value = taskId;
      document.getElementById('taskDetailsTitle').textContent = taskTitle || 'Task Details';
      document.getElementById('taskCommentText').value = '';
      document.getElementById('taskCommentsList').innerHTML = '<div class="task-detail-empty">Loading comments...</div>';
      document.getElementById('taskActivityList').innerHTML = '<div class="task-detail-empty">Loading activity...</div>';
      document.getElementById('taskDetailsModal').classList.add('active');
      document.body.style.overflow = 'hidden';
      loadTaskDetails(taskId);
    }

    function closeTaskDetails() {
      document.getElementById('taskDetailsModal').classList.remove('active');
      document.body.style.overflow = '';
      activeDetailsTaskId = null;
    }

    function renderTaskDetails(data) {
      const commentsList = document.getElementById('taskCommentsList');
      const activityList = document.getElementById('taskActivityList');

      commentsList.innerHTML = data.comments.length ? data.comments.map(comment => `
        <div class="task-detail-item">
          <div class="task-detail-meta">${escapeHtml(comment.author_name || 'Unknown user')} &bull; ${formatDateTime(comment.created_at)}</div>
          <p class="task-detail-text">${escapeHtml(comment.comment)}</p>
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
      fetch('tasksData/ctrl.get.task.details.php?task_id=' + encodeURIComponent(taskId))
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            showToast(data.message || 'Could not load task details.');
            return;
          }
          renderTaskDetails(data);
        })
        .catch(() => showToast('Could not load task details.'));
    }

    /* Action buttons template */
    const actionBtns = `
      <div class="d-flex justify-content-center gap-2">
        <button class="btn-act btn-edit" title="Edit task" onclick="openEditModal(this)">
          <svg viewBox="0 0 24 24" fill="none"><path d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button class="btn-act btn-delete" title="Delete task" onclick="this.closest('tr').remove(); updateCount();">
          <svg viewBox="0 0 24 24" fill="none"><path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>`;

    /* ── Add Modal ── */
    function openModal() {
      document.getElementById('addTaskModal').classList.add('active');
      document.getElementById('taskTitle').focus();
      document.body.style.overflow = 'hidden';
    }
    function closeModal() {
      document.getElementById('addTaskModal').classList.remove('active');
      document.body.style.overflow = '';
      document.getElementById('taskTitle').value = '';
      document.getElementById('taskDesc').value = '';
      document.getElementById('taskAssignee').value = '';
      document.getElementById('taskDue').value = '';
      document.getElementById('taskPriority').value = '';
      document.getElementById('taskStatus').value = 'In Progress';
      document.getElementById('taskTitle').classList.remove('error');
      document.getElementById('titleError').style.display = 'none';
    }
    document.getElementById('addTaskModal').addEventListener('click', function (e) {
      if (e.target === this) closeModal();
    });

    function submitTask() {
      const title = document.getElementById('taskTitle').value.trim();
      const desc = document.getElementById('taskDesc').value.trim();
      const assigneeV = document.getElementById('taskAssignee').value;
      const due = document.getElementById('taskDue').value;
      const priority = document.getElementById('taskPriority').value;
      const status = document.getElementById('taskStatus').value || 'In Progress';

      if (!title) {
        document.getElementById('taskTitle').classList.add('error');
        document.getElementById('titleError').style.display = 'block';
        document.getElementById('taskTitle').focus();
        return;
      }
      document.getElementById('taskTitle').classList.remove('error');
      document.getElementById('titleError').style.display = 'none';

      let assigneeHTML = '<span style="font-size:0.85rem;color:#adb5bd;">Unassigned</span>';
      if (assigneeV) {
        const [name, initials, color] = assigneeV.split('|');
        assigneeHTML = `<div class="d-flex align-items-center"><span class="avatar-sm" style="background:${color};">${initials}</span><span style="font-size:0.85rem;margin-left:8px;">${name}</span></div>`;
      }

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><p class="task-title">${escapeHtml(title)}</p>${desc ? '<p class="task-desc">' + escapeHtml(desc) + '</p>' : ''}</td>
        <td>${assigneeHTML}</td>
        <td>${priority ? '<span class="badge-pill ' + priorityClass(priority) + '">' + priority + '</span>' : '<span style="color:#adb5bd;font-size:0.85rem;">—</span>'}</td>
        <td><span class="badge-pill ${statusClass(status)}">${status}</span></td>
        <td>${formatDate(due)}</td>
        <td style="text-align:center;">${actionBtns}</td>
      `;
      document.getElementById('taskTableBody').prepend(tr);
      updateCount();
      closeModal();
      showToast('"' + title + '" added successfully!');
    }

    /* ── Edit Modal ── */
    let editingRow = null;

    function openEditModal(taskId, title, desc, assigneeId, due, priority, status) {
      document.getElementById('editTaskId').value = taskId;
      document.getElementById('editTitle').value = title;
      document.getElementById('editDesc').value = desc;
      document.getElementById('editAssignee').value = assigneeId;
      document.getElementById('editDue').value = due;
      document.getElementById('editPriority').value = priority;
      document.getElementById('editStatus').value = status;
      document.getElementById('editTaskModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }
    function closeEditModal() {
      document.getElementById('editTaskModal').classList.remove('active');
      document.body.style.overflow = '';
      editingRow = null;
    }
    document.getElementById('editTaskModal').addEventListener('click', function (e) {
      if (e.target === this) closeEditModal();
    });

    document.getElementById('taskDetailsModal').addEventListener('click', function (e) {
      if (e.target === this) closeTaskDetails();
    });

    document.getElementById('taskCommentForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const taskId = document.getElementById('commentTaskId').value;
      const commentText = document.getElementById('taskCommentText').value.trim();

      if (!commentText) {
        document.getElementById('taskCommentText').focus();
        return;
      }

      const formData = new FormData();
      formData.append('task_id', taskId);
      formData.append('comment', commentText);

      fetch('tasksData/ctrl.add.comment.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            showToast(data.message || 'Could not save comment.');
            return;
          }
          document.getElementById('taskCommentText').value = '';
          showToast('Comment added.');
          loadTaskDetails(taskId);
        })
        .catch(() => showToast('Could not save comment.'));
    });

    function openDeleteModal(taskId, taskName) {
      document.getElementById('deleteTaskId').value = taskId;
      document.getElementById('deleteTaskName').textContent = taskName;
      document.getElementById('deleteTaskModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }
    function closeDeleteModal() {
      document.getElementById('deleteTaskModal').classList.remove('active');
      document.body.style.overflow = '';
    }

    function saveTask() {
      const title = document.getElementById('editTitle').value.trim();
      const desc = document.getElementById('editDesc').value.trim();
      const priority = document.getElementById('editPriority').value;
      const status = document.getElementById('editStatus').value || 'In Progress';
      const due = document.getElementById('editDue').value;
      const assigneeV = document.getElementById('editAssignee').value;

      if (!title) {
        document.getElementById('editTitle').classList.add('error');
        document.getElementById('editTitleError').style.display = 'block';
        document.getElementById('editTitle').focus();
        return;
      }
      document.getElementById('editTitle').classList.remove('error');
      document.getElementById('editTitleError').style.display = 'none';
      if (!editingRow) return;

      editingRow.querySelector('.task-title').textContent = title;
      const descEl = editingRow.querySelector('.task-desc');
      if (descEl) descEl.textContent = desc;

      const pBadge = editingRow.querySelector('.badge-high, .badge-medium, .badge-low');
      if (pBadge && priority) { pBadge.textContent = priority; pBadge.className = 'badge-pill ' + priorityClass(priority); }

      const sBadge = editingRow.querySelector('.badge-progress, .badge-done, .badge-pending');
      if (sBadge) { sBadge.textContent = status; sBadge.className = 'badge-pill ' + statusClass(status); }

      editingRow.cells[5].innerHTML = formatDate(due);

      if (assigneeV) {
        const [name, initials, color] = assigneeV.split('|');
        const avatar = editingRow.querySelector('.avatar-sm');
        const nameEl = editingRow.querySelector('.avatar-sm + span');
        if (avatar) { avatar.textContent = initials; avatar.style.background = color; }
        if (nameEl) nameEl.textContent = name;
      }

      closeEditModal();
      showToast('"' + title + '" updated successfully!');
    }



    /* Escape key closes any open modal */
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { closeModal(); closeEditModal(); closeTaskDetails(); closeDeleteModal(); closeBulkDeleteModal(); }
    });

    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    // hide the button until at least one task is selected
    deleteSelectedBtn.style.display = 'none';

    function updateDeleteSelectedButton() {
      const checkedCount = document.querySelectorAll('.task-checkbox:checked').length;
      if (checkedCount === 0) {
        deleteSelectedBtn.disabled = true;
        deleteSelectedBtn.style.display = 'none';
      } else {
        deleteSelectedBtn.disabled = false;
        deleteSelectedBtn.style.display = 'inline-block';
      }
    }

    document.addEventListener('change', function (e) {
      if (e.target.id === 'selectAllTasks') {
        document.querySelectorAll('.task-checkbox').forEach(checkbox => {
          checkbox.checked = e.target.checked;
        });

        updateDeleteSelectedButton();
      }

      if (e.target.classList.contains('task-checkbox')) {
        updateDeleteSelectedButton();
      }
    });



    document.getElementById('bulkDeleteForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const checkedCount = document.querySelectorAll('.task-checkbox:checked').length;
      if (checkedCount === 0) return;
      document.getElementById('bulkDeleteCount').textContent = checkedCount;
      document.getElementById('bulkDeleteModal').classList.add('active');
      document.body.style.overflow = 'hidden';

      document.getElementById('bulkDeleteConfirmBtn').onclick = () => {
        document.getElementById('bulkDeleteModal').classList.remove('active');
        document.body.style.overflow = '';
        const form = document.getElementById('bulkDeleteForm');
        if (!form.querySelector('input[name="delete_selected"]')) {
          const hidden = document.createElement('input');
          hidden.type = 'hidden';
          hidden.name = 'delete_selected';
          hidden.value = '1';
          form.appendChild(hidden);
        }
        form.submit();
      };
    });

    function closeBulkDeleteModal() {
      document.getElementById('bulkDeleteModal').classList.remove('active');
      document.body.style.overflow = '';
    }

    function applyFilters() {
      const priority = document.getElementById('filterPriority').value;
      const status = document.getElementById('filterStatus').value;
      const sort = document.getElementById('filterSort').value;
      const search = document.getElementById('searchInput').value;
      const params = new URLSearchParams();
      if (search) params.set('search', search);
      if (priority) params.set('priority', priority);
      if (status) params.set('status', status);
      if (sort) params.set('sort', sort);
      params.set('page', '1');
      window.location.href = '?' + params.toString();
    }
    /* Init */
    updateCount();

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'add') { showToast('Task added successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }
    if (urlParams.get('success') === 'edit') { showToast('Task updated successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }
    if (urlParams.get('success') === 'delete') { showToast('Task deleted successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }
  </script>
</body>

</html>