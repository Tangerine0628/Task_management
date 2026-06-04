<?php
require_once '../../includes/session.php';
require_once '../../includes/guard.admin.php';
require_once '../../includes/conn.php';
$select_user = mysqli_query($conn, "SELECT * FROM tbl_users ORDER BY created_at DESC");
?>

<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TaskFlow | User Management</title>
  <!-- Links -->
  <?php include '../../includes/link.php'; ?>
  <style>
    .btn-prof-status {
      background: linear-gradient(135deg, #f39c12, #e67e22);
      color: #fff;
      box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
    }

    .btn-prof-status:hover {
      box-shadow: 0 6px 18px rgba(243, 156, 18, 0.45);
    }

    .modal-hdr-title.orange svg {
      color: #f39c12;
    }

    .status-chip {
      padding: 7px 16px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      border: 2px solid transparent;
      transition: all 0.15s;
    }

    .status-chip.selected {
      border-color: currentColor;
      transform: scale(1.05);
    }

    .status-chip[data-status="Active"] {
      background: #e8f8f0;
      color: #27ae60;
    }

    .status-chip[data-status="Inactive"] {
      background: #f3f4f6;
      color: #6c757d;
    }

    .btn-submit-orange {
      padding: 9px 22px;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: linear-gradient(135deg, #f39c12, #e67e22);
      box-shadow: 0 4px 12px rgba(243, 156, 18, 0.35);
      transition: transform 0.15s, box-shadow 0.15s;
    }

    .btn-submit-orange:hover {
      transform: translateY(-1px);
    }

    .btn-submit-orange svg {
      width: 15px;
      height: 15px;
    }

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

    .btn-add-user {
      background: linear-gradient(135deg, #3a8ef6 0%, #2b7de0 100%);
      color: #fff;
      border: none;
      padding: 10px 22px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.92rem;
      letter-spacing: 0.3px;
      box-shadow: 0 4px 15px rgba(58, 142, 246, 0.38);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .btn-add-user:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(58, 142, 246, 0.52);
      color: #fff;
    }

    .btn-add-user svg {
      width: 16px;
      height: 16px;
    }

    .um-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
      overflow: hidden;
      display: flex;
      min-height: 600px;
    }

    /* Left panel */
    .um-list {
      width: 320px;
      flex-shrink: 0;
      border-right: 1px solid #f0f2f5;
      display: flex;
      flex-direction: column;
    }

    .um-list-header {
      padding: 16px 16px 12px;
      border-bottom: 1px solid #f0f2f5;
    }

    .um-list-header h6 {
      font-size: 0.95rem;
      font-weight: 700;
      color: #212529;
      margin: 0 0 10px;
    }

    .um-search {
      position: relative;
    }

    .um-search input {
      width: 100%;
      box-sizing: border-box;
      padding: 8px 12px 8px 32px;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      font-size: 0.83rem;
      outline: none;
      background: #f8f9fa;
      transition: border-color 0.2s;
    }

    .um-search input:focus {
      border-color: #3a8ef6;
      background: #fff;
    }

    .um-search svg {
      position: absolute;
      left: 9px;
      top: 50%;
      transform: translateY(-50%);
      width: 14px;
      height: 14px;
      color: #adb5bd;
    }

    .um-filter-row {
      display: flex;
      gap: 6px;
      margin-top: 8px;
    }

    .um-filter-select {
      flex: 1;
      padding: 6px 8px;
      border: 1px solid #e9ecef;
      border-radius: 7px;
      font-size: 0.78rem;
      outline: none;
      background: #f8f9fa;
      color: #495057;
      cursor: pointer;
    }

    .um-filter-select:focus {
      border-color: #3a8ef6;
    }

    .um-list-body {
      flex: 1;
      overflow-y: auto;
      max-height: 500px;
    }

    .um-list-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 16px;
      cursor: pointer;
      border-bottom: 1px solid #f8f9fa;
      transition: background 0.12s;
    }

    .um-list-item:hover {
      background: #f8f9ff;
    }

    .um-list-item.active {
      background: #eff5ff;
      border-left: 3px solid #3a8ef6;
    }

    .um-list-item.active .um-li-name {
      color: #3a8ef6;
    }

    .um-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .um-li-name {
      font-size: 0.875rem;
      font-weight: 600;
      color: #212529;
      margin: 0 0 2px;
    }

    .um-li-role {
      font-size: 0.75rem;
      color: #adb5bd;
      margin: 0;
    }

    .um-li-status {
      margin-left: auto;
    }

    .status-dot {
      width: 9px;
      height: 9px;
      border-radius: 50%;
      display: inline-block;
    }

    .status-active {
      background: #27ae60;
    }

    .status-inactive {
      background: #adb5bd;
    }

    .um-list-empty {
      padding: 32px 16px;
      text-align: center;
      font-size: 0.85rem;
      color: #adb5bd;
      display: none;
    }

    /* Right panel */
    .um-detail {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .um-empty-state {
      text-align: center;
      color: #adb5bd;
    }

    .um-empty-state svg {
      width: 52px;
      height: 52px;
      margin-bottom: 12px;
      opacity: 0.35;
    }

    .um-empty-state p {
      font-size: 0.875rem;
      margin: 0;
    }

    .um-profile {
      width: 100%;
      height: 100%;
      display: none;
      flex-direction: column;
    }

    .um-profile.visible {
      display: flex;
    }

    .um-profile-header {
      padding: 28px 28px 20px;
      border-bottom: 1px solid #f0f2f5;
      display: flex;
      align-items: center;
      gap: 18px;
    }

    .um-profile-avatar {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }

    .um-profile-name {
      font-size: 1.1rem;
      font-weight: 700;
      color: #212529;
      margin: 0 0 5px;
    }

    .um-profile-meta {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    .badge-role {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.73rem;
      font-weight: 600;
    }

    .role-admin {
      background: #e8f0fe;
      color: #3a8ef6;
    }

    .role-user {
      background: #f3f4f6;
      color: #6c757d;
    }

    .badge-status {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.73rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .badge-active {
      background: #e8f8f0;
      color: #27ae60;
    }

    .badge-inactive {
      background: #f3f4f6;
      color: #6c757d;
    }

    .um-profile-body {
      padding: 24px 28px;
      flex: 1;
      overflow-y: auto;
    }

    .um-info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px 24px;
      margin-bottom: 24px;
    }

    .um-info-label {
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #adb5bd;
      margin: 0 0 4px;
    }

    .um-info-value {
      font-size: 0.875rem;
      color: #212529;
      margin: 0;
      font-weight: 500;
    }

    .um-profile-actions {
      padding: 16px 28px;
      border-top: 1px solid #f0f2f5;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn-prof {
      padding: 9px 18px;
      border-radius: 8px;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      border: none;
      transition: transform 0.12s, box-shadow 0.12s;
    }

    .btn-prof svg {
      width: 15px;
      height: 15px;
    }

    .btn-prof:hover {
      transform: translateY(-1px);
    }

    .btn-prof-edit {
      background: linear-gradient(135deg, #3a8ef6, #2b7de0);
      color: #fff;
      box-shadow: 0 4px 12px rgba(58, 142, 246, 0.3);
    }

    .btn-prof-edit:hover {
      box-shadow: 0 6px 18px rgba(58, 142, 246, 0.45);
    }

    .btn-prof-role {
      background: linear-gradient(135deg, #8e44ad, #7d3c98);
      color: #fff;
      box-shadow: 0 4px 12px rgba(142, 68, 173, 0.3);
    }

    .btn-prof-role:hover {
      box-shadow: 0 6px 18px rgba(142, 68, 173, 0.45);
    }

    .btn-prof-delete {
      background: #fff0f0;
      color: #d63031;
      border: 1px solid #ffd5d5 !important;
    }

    .btn-prof-delete:hover {
      background: #d63031;
      color: #fff;
    }

    /* Modals */
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

    .modal-card {
      background: #fff;
      border-radius: 14px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
      overflow: hidden;
      animation: modalIn 0.2s ease;
    }

    .modal-card-sm {
      max-width: 380px;
    }

    @keyframes modalIn {
      from {
        opacity: 0;
        transform: translateY(-18px) scale(0.97)
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1)
      }
    }

    .modal-hdr {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.1rem 1.35rem 0.9rem;
      border-bottom: 1px solid #f0f2f5;
    }

    .modal-hdr-title {
      font-size: 1rem;
      font-weight: 700;
      color: #212529;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .modal-hdr-title svg {
      width: 18px;
      height: 18px;
    }

    .modal-hdr-title.blue svg {
      color: #3a8ef6;
    }

    .modal-hdr-title.purple svg {
      color: #8e44ad;
    }

    .modal-hdr-title.red svg {
      color: #d63031;
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
    }

    .modal-close svg {
      width: 16px;
      height: 16px;
    }

    .modal-bdy {
      padding: 1.35rem;
    }

    .modal-ftr {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 8px;
      padding: 0.9rem 1.35rem;
      border-top: 1px solid #f0f2f5;
      background: #fafbfc;
    }

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
    .form-select {
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
    .form-select:focus {
      border-color: #3a8ef6;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(58, 142, 246, 0.1);
    }

    .form-input.error {
      border-color: #d63031;
      box-shadow: 0 0 0 3px rgba(214, 48, 49, 0.1);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .form-error {
      display: none;
      font-size: 0.78rem;
      color: #d63031;
      margin-top: 4px;
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

    .btn-submit-blue,
    .btn-submit-purple,
    .btn-submit-red {
      padding: 9px 22px;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: transform 0.15s, box-shadow 0.15s;
    }

    .btn-submit-blue {
      background: linear-gradient(135deg, #3a8ef6, #2b7de0);
      box-shadow: 0 4px 12px rgba(58, 142, 246, 0.35);
    }

    .btn-submit-purple {
      background: linear-gradient(135deg, #8e44ad, #7d3c98);
      box-shadow: 0 4px 12px rgba(142, 68, 173, 0.35);
    }

    .btn-submit-red {
      background: linear-gradient(135deg, #d63031, #c0392b);
      box-shadow: 0 4px 12px rgba(214, 48, 49, 0.35);
    }

    .btn-submit-blue:hover,
    .btn-submit-purple:hover,
    .btn-submit-red:hover {
      transform: translateY(-1px);
    }

    .btn-submit-blue svg,
    .btn-submit-purple svg,
    .btn-submit-red svg {
      width: 15px;
      height: 15px;
    }

    /* Role chips — Admin & User only */
    .role-chips {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .role-chip {
      padding: 7px 16px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      border: 2px solid transparent;
      transition: all 0.15s;
    }

    .role-chip.selected {
      border-color: currentColor;
      transform: scale(1.05);
    }

    .role-chip[data-role="Admin"] {
      background: #e8f0fe;
      color: #3a8ef6;
    }

    .role-chip[data-role="User"] {
      background: #f3f4f6;
      color: #6c757d;
    }

    /* Delete confirm */
    .delete-confirm-icon {
      text-align: center;
      margin-bottom: 12px;
    }

    .delete-confirm-icon svg {
      width: 44px;
      height: 44px;
      color: #d63031;
    }

    .delete-confirm-text {
      text-align: center;
      font-size: 0.9rem;
      color: #495057;
    }

    .delete-confirm-text strong {
      color: #212529;
    }

    /* Toast */
    .toast-notify {
      position: fixed;
      bottom: 28px;
      right: 28px;
      background: #fff;
      border: 1px solid #e9ecef;
      border-left: 4px solid #27ae60;
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
      color: #27ae60;
      flex-shrink: 0;
    }

    @media (max-width:768px) {
      .um-card {
        flex-direction: column;
      }

      .um-list {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid #f0f2f5;
        max-height: 300px;
      }

      .um-info-grid {
        grid-template-columns: 1fr;
      }
    }

    .gap-2 {
      gap: 0.5rem !important;
    }
  </style>
</head>

<body class="">
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>

  <!-- ── Sidebar ── -->

  <?php
  $activePage = 'users'; //
  include '../../includes/sidebar.php';
  ?>

  <!-- ── Main ── -->
  <main class="main-content">
    <div class="position-relative iq-banner">

      <!-- Navbar -->
      <?php include '../../includes/navbar.php'; ?>

      <!-- Page Header -->
      <div class="iq-navbar-header" style="height:215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                  <h1>User Management</h1>
                  <p>Manage team members, roles, and account access.</p>
                </div>
                <div>
                  <button class="btn-add-user" onclick="openAddModal()">
                    <svg viewBox="0 0 24 24" fill="none">
                      <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                    Add User
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
          <div class="um-card">

            <!-- LEFT: User List -->
            <div class="um-list">
              <div class="um-list-header">
                <h6>All Users <span id="userCountBadge" style="font-size:0.78rem;font-weight:400;color:#adb5bd;"></span>
                </h6>
                <div class="um-search">
                  <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.8" />
                    <path d="M17 17L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                  </svg>
                  <input type="text" id="userSearch" placeholder="Search users..." oninput="filterUsers()">
                </div>
                <div class="um-filter-row">
                  <!-- ✅ Admin and User only -->
                  <select class="um-filter-select" id="filterRole" onchange="filterUsers()">
                    <option value="">All Roles</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                  </select>
                  <select class="um-filter-select" id="filterStatus" onchange="filterUsers()">
                    <option value="">All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                  </select>
                </div>
              </div>
              <div class="um-list-body" id="userListBody"></div>
              <div class="um-list-empty" id="listEmpty">No users found.</div>
              <!-- 1. Inject PHP data as a JS array (place this before your closing </div> or in a <script> block) -->
              <script>
                const allUsers = [
                  <?php
                  $colors = ['#3a8ef6', '#d63031', '#27ae60', '#8e44ad', '#e67e22', '#2d3436', '#0984e3', '#6c5ce7', '#00b894', '#e17055'];
                  $i = 0;
                  while ($row = mysqli_fetch_array($select_user)) {
                    echo "{";
                    echo "user_id: " . json_encode($row['user_id']) . ",";
                    echo "first_name: " . json_encode($row['first_name']) . ",";
                    echo "last_name: " . json_encode($row['last_name']) . ",";
                    echo "email: " . json_encode($row['email']) . ",";
                    echo "role: " . json_encode($row['role']) . ",";
                    echo "status: " . json_encode($row['status']) . ",";
                    echo "created_at: " . json_encode($row['created_at']) . ",";
                    echo "color: " . json_encode($colors[$i % count($colors)]);
                    echo "},";
                    $i++;
                  }
                  ?>
                ];
                document.addEventListener('DOMContentLoaded', () => {
                  filterUsers();
                });
              </script>
            </div>

            <!-- RIGHT: User Detail -->
            <div class="um-detail" id="umDetail">
              <div class="um-empty-state" id="emptyState">
                <svg viewBox="0 0 24 24" fill="none">
                  <path opacity="0.4"
                    d="M15.5 8C15.5 10.2091 13.7091 12 11.5 12C9.29086 12 7.5 10.2091 7.5 8C7.5 5.79086 9.29086 4 11.5 4C13.7091 4 15.5 5.79086 15.5 8Z"
                    fill="currentColor" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.5 14C7.35786 14 4 17.3579 4 21.5C4 21.7761 4.22386 22 4.5 22H18.5C18.7761 22 19 21.7761 19 21.5C19 17.3579 15.6421 14 11.5 14Z"
                    fill="currentColor" />
                </svg>
                <p>Select a user to view their profile</p>
              </div>
              <div class="um-profile" id="umProfile">
                <div class="um-profile-header">
                  <div class="um-profile-avatar" id="profAvatar"></div>
                  <div>
                    <p class="um-profile-name" id="profName"></p>
                    <div class="um-profile-meta">
                      <span class="badge-role" id="profRoleBadge"></span>
                      <span class="badge-status" id="profStatusBadge"></span>
                    </div>
                  </div>
                </div>
                <div class="um-profile-body">
                  <div class="um-info-grid">
                    <div class="um-info-item">
                      <p class="um-info-label">Email</p>
                      <p class="um-info-value" id="profEmail">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                          style="margin-right:5px;vertical-align:middle;color:#adb5bd;">
                          <path
                            d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                          <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                        </svg>
                        <span id="profEmailVal"></span>
                      </p>
                    </div>
                    <div class="um-info-item">
                      <p class="um-info-label">Role</p>
                      <p class="um-info-value" id="profRole">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                          style="margin-right:5px;vertical-align:middle;color:#adb5bd;">
                          <path
                            d="M12 15C15.3137 15 18 12.3137 18 9C18 5.68629 15.3137 3 12 3C8.68629 3 6 5.68629 6 9C6 12.3137 8.68629 15 12 15Z"
                            stroke="currentColor" stroke-width="1.8" />
                          <path
                            d="M2.90625 20.2491C3.82834 18.6531 5.15423 17.3278 6.75064 16.4064C8.34705 15.485 10.1579 15 12.0011 15C13.8444 15 15.6552 15.4851 17.2516 16.4065C18.848 17.3279 20.1739 18.6533 21.0959 20.2493"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        <span id="profRoleVal"></span>
                      </p>
                    </div>
                    <div class="um-info-item">
                      <p class="um-info-label">Status</p>
                      <p class="um-info-value" id="profStatus">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                          style="margin-right:5px;vertical-align:middle;color:#adb5bd;">
                          <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.8" />
                          <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        <span id="profStatusVal"></span>
                      </p>
                    </div>
                    <div class="um-info-item">
                      <p class="um-info-label">Joined</p>
                      <p class="um-info-value" id="profJoined">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                          style="margin-right:5px;vertical-align:middle;color:#adb5bd;">
                          <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8" />
                          <path d="M16 2V6M8 2V6M3 10H21" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                        </svg>
                        <span id="profJoinedVal"></span>
                      </p>
                    </div>
                  </div>
                </div>
                <!-- ✅ Deactivate button removed -->
                <div class="um-profile-actions">
                  <button class="btn-prof btn-prof-edit" onclick="openEditModal()">
                    <svg viewBox="0 0 24 24" fill="none">
                      <path
                        d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path
                        d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Edit Profile
                  </button>
                  <button class="btn-prof btn-prof-role" onclick="openRoleModal()">
                    <svg viewBox="0 0 24 24" fill="none">
                      <path
                        d="M12 15C15.3137 15 18 12.3137 18 9C18 5.68629 15.3137 3 12 3C8.68629 3 6 5.68629 6 9C6 12.3137 8.68629 15 12 15Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path
                        d="M2.90625 20.2491C3.82834 18.6531 5.15423 17.3278 6.75064 16.4064C8.34705 15.485 10.1579 15 12.0011 15C13.8444 15 15.6552 15.4851 17.2516 16.4065C18.848 17.3279 20.1739 18.6533 21.0959 20.2493"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Change Role
                  </button>
                  <button class="btn-prof btn-prof-status" onclick="openStatusModal()">
                    <svg viewBox="0 0 24 24" fill="none">
                      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                      <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Change Status
                  </button>
                  <button class="btn-prof btn-prof-delete" onclick="openDeleteModal()">
                    <svg viewBox="0 0 24 24" fill="none">
                      <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                      <path
                        d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Delete
                  </button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="footer-body">
        <ul class="left-panel list-inline mb-0 p-0">
          <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
          <li class="list-inline-item"><a href="#">Terms of Use</a></li>
        </ul>
        <div class="right-panel">&copy;
          <script>document.write(new Date().getFullYear())</script> TaskFlow, Made with &hearts; by IQONIC Design.
        </div>
      </div>
    </footer>
  </main>

  <!-- ADD USER MODAL -->
  <div class="modal-overlay" id="addUserModal" role="dialog" aria-modal="true">
    <div class="modal-card">
      <div class="modal-hdr">
        <p class="modal-hdr-title blue">
          <svg viewBox="0 0 24 24" fill="none">
            <path
              d="M16 11C18.2091 11 20 9.20914 20 7C20 4.79086 18.2091 3 16 3M16 11C13.7909 11 12 9.20914 12 7C12 4.79086 13.7909 3 16 3M16 11V21M16 3V1"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path d="M2 21C2 17.134 5.13401 14 9 14C10.4956 14 11.8849 14.4594 13.0307 15.2422" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" />
            <path
              d="M9 14C6.79086 14 5 12.2091 5 10C5 7.79086 6.79086 6 9 6C11.2091 6 13 7.79086 13 10C13 12.2091 11.2091 14 9 14Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Add New User
        </p>
        <button class="modal-close" onclick="closeModal('addUserModal')">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <div class="modal-bdy">
        <form method="POST" action="userData/ctrl.add.user.php">
          <div class="form-row">
            <div class="form-field">
              <label class="form-label">First Name <span style="color:#d63031">*</span></label>
              <input class="form-input" type="text" id="addFirstName" name="first_name" placeholder="First name"
                required>
              <span class="form-error" id="addFirstNameErr">Required.</span>
            </div>
            <div class="form-field">
              <label class="form-label">Last Name <span style="color:#d63031">*</span></label>
              <input class="form-input" type="text" id="addLastName" name="last_name" placeholder="Last name" required>
              <span class="form-error" name="last_name" id="addLastNameErr">Required.</span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="form-label">Role</label>
              <!-- ✅ Admin and User only -->
              <select class="form-select" name="role" id="addRole">
                <option value="User">User</option>
                <option value="Admin">Admin</option>
              </select>
            </div>
          </div>
          <div class="form-field">
            <label class="form-label">Email <span style="color:#d63031">*</span></label>
            <input class="form-input" type="email" id="addEmail" name="email" placeholder="user@email.com" required>
            <span class="form-error" id="addEmailErr">Enter a valid email.</span>
          </div>
          <div class="form-field">
            <label class="form-label">Password <span style="color:#d63031">*</span></label>
            <input class="form-input" type="password" id="addPassword" name="password" placeholder="Enter password"
              required minlength="8">
            <span class="form-error" id="addPasswordErr">Password must be at least 8 characters.</span>
          </div>

          <div class="modal-ftr">
            <button type="button" class="btn-cancel-modal" onclick="closeModal('addUserModal')">Cancel</button>
            <button type="submit" name="button" class="btn-submit-blue">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
              </svg>
              Add User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- EDIT USER MODAL -->
  <div class="modal-overlay" id="editUserModal" role="dialog" aria-modal="true">
    <div class="modal-card">
      <div class="modal-hdr">
        <p class="modal-hdr-title blue">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Edit Profile
        </p>
        <button class="modal-close" onclick="closeModal('editUserModal')">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <form method="POST" action="userData/ctrl.edit.user.php">
        <input type="hidden" name="user_id" id="editUserId">
        <div class="modal-bdy">
          <div class="form-row">
            <div class="form-field">
              <label class="form-label">First Name <span style="color:#d63031">*</span></label>
              <input class="form-input" type="text" name="first_name" id="editFirstName">
              <span class="form-error" id="editFirstNameErr">Required.</span>
            </div>
            <div class="form-field">
              <label class="form-label">Last Name <span style="color:#d63031">*</span></label>
              <input class="form-input" type="text" name="last_name" id="editLastName">
              <span class="form-error" id="editLastNameErr">Required.</span>
            </div>
          </div>
          <div class="form-field">
            <label class="form-label">Email <span style="color:#d63031">*</span></label>
            <input class="form-input" type="email" name="email" id="editEmail">
            <span class="form-error" id="editEmailErr">Enter a valid email.</span>
          </div>
        </div>
        <div class="modal-ftr">
          <button type="button" class="btn-cancel-modal" onclick="closeModal('editUserModal')">Cancel</button>
          <button type="submit" name="button" class="btn-submit-blue">
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

  <!-- CHANGE ROLE MODAL -->
  <div class="modal-overlay" id="roleModal" role="dialog" aria-modal="true">
    <div class="modal-card modal-card-sm">
      <div class="modal-hdr">
        <p class="modal-hdr-title purple">
          <svg viewBox="0 0 24 24" fill="none">
            <path
              d="M12 15C15.3137 15 18 12.3137 18 9C18 5.68629 15.3137 3 12 3C8.68629 3 6 5.68629 6 9C6 12.3137 8.68629 15 12 15Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path
              d="M2.90625 20.2491C3.82834 18.6531 5.15423 17.3278 6.75064 16.4064C8.34705 15.485 10.1579 15 12.0011 15C13.8444 15 15.6552 15.4851 17.2516 16.4065C18.848 17.3279 20.1739 18.6533 21.0959 20.2493"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Change Role
        </p>
        <button type="button" class="modal-close" onclick="closeModal('roleModal')">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <form method="POST" action="userData/ctrl.role.user.php">
        <input type="hidden" name="user_id" id="roleUserId">
        <input type="hidden" name="role" id="roleInput">
        <div class="modal-bdy">
          <p style="font-size:0.85rem;color:#6c757d;margin:0 0 14px;">Select a new role for <strong id="roleModalName"
              style="color:#212529;"></strong>:</p>
          <div class="role-chips" id="roleChips">
            <span class="role-chip" data-role="Admin" onclick="selectRole(this)">Admin</span>
            <span class="role-chip" data-role="User" onclick="selectRole(this)">User</span>
          </div>
        </div>
        <div class="modal-ftr">
          <button type="button" class="btn-cancel-modal" onclick="closeModal('roleModal')">Cancel</button>
          <button type="submit" name="button" class="btn-submit-purple">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Apply Role
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- DELETE CONFIRM MODAL -->
  <div class="modal-overlay" id="deleteModal" role="dialog" aria-modal="true">
    <div class="modal-card modal-card-sm">
      <div class="modal-hdr">
        <p class="modal-hdr-title red">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Delete User
        </p>
        <button type="button" class="modal-close" onclick="closeModal('deleteModal')">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <form method="POST" action="userData/ctrl.delete.user.php">
        <input type="hidden" name="user_id" id="deleteUserId">
        <div class="modal-bdy">
          <div class="delete-confirm-icon">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
          </div>
          <p class="delete-confirm-text">Are you sure you want to delete <strong id="deleteModalName"></strong>? This
            action cannot be undone.</p>
        </div>
        <div class="modal-ftr">
          <button type="button" class="btn-cancel-modal" onclick="closeModal('deleteModal')">Cancel</button>
          <button type="submit" name="button" class="btn-submit-red">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
              <path
                d="M8 6V4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V6M19 6L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 6H19Z"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Yes, Delete
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- CHANGE STATUS MODAL -->
  <div class="modal-overlay" id="statusModal" role="dialog" aria-modal="true">
    <div class="modal-card modal-card-sm">
      <div class="modal-hdr">
        <p class="modal-hdr-title orange">
          <svg viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Change Status
        </p>
        <button type="button" class="modal-close" onclick="closeModal('statusModal')">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <form method="POST" action="userData/ctrl.status.user.php">
        <input type="hidden" name="user_id" id="statusUserId">
        <input type="hidden" name="status" id="statusInput">
        <div class="modal-bdy">
          <p style="font-size:0.85rem;color:#6c757d;margin:0 0 14px;">Select a new status for <strong
              id="statusModalName" style="color:#212529;"></strong>:</p>
          <div class="role-chips">
            <span class="status-chip" data-status="Active" onclick="selectStatus(this)">Active</span>
            <span class="status-chip" data-status="Inactive" onclick="selectStatus(this)">Inactive</span>
          </div>
        </div>
        <div class="modal-ftr">
          <button type="button" class="btn-cancel-modal" onclick="closeModal('statusModal')">Cancel</button>
          <button type="submit" name="button" class="btn-submit-orange">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
            </svg>
            Apply Status
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast -->
  <div class="toast-notify" id="toastNotify">
    <svg viewBox="0 0 24 24" fill="none">
      <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
        stroke-linejoin="round" />
    </svg>
    <span id="toastMsg">Done!</span>
  </div>

  <?php include '../../includes/scripts.php'; ?>

  <script>
    const AVATAR_COLORS = ['#3a8ef6', '#d63031', '#27ae60', '#8e44ad', '#e67e22', '#2d3436', '#0984e3', '#6c5ce7', '#00b894', '#e17055'];

    let selectedUserId = null;

    /* ── Helpers ── */
    function initials(u) {
      return ((u.first_name?.[0] || '') + (u.last_name?.[0] || '')).toUpperCase();
    }
    function roleClass(role) { return role === 'Admin' ? 'role-admin' : 'role-user'; }
    function escHtml(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }

    function showToast(msg) {
      const t = document.getElementById('toastNotify');
      document.getElementById('toastMsg').textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 3000);
    }

    /* ── Render list ── */
    function renderList(list) {
      const body = document.getElementById('userListBody');
      const empty = document.getElementById('listEmpty');
      body.innerHTML = '';
      if (!list.length) { empty.style.display = 'block'; return; }
      empty.style.display = 'none';
      list.forEach(u => {
        const div = document.createElement('div');
        div.className = 'um-list-item' + (u.user_id === selectedUserId ? ' active' : '');
        div.dataset.id = u.user_id;
        div.onclick = () => selectUser(u.user_id);
        div.innerHTML = `
          <div class="um-avatar" style="background:${u.color}">${initials(u)}</div>
          <div style="flex:1;min-width:0">
            <p class="um-li-name">${escHtml(u.first_name + ' ' + u.last_name)}</p>
            <p class="um-li-role">${escHtml(u.role)}</p>
          </div>
          <div class="um-li-status">
            <span class="status-dot ${u.status === 'Active' ? 'status-active' : 'status-inactive'}" title="${u.status}"></span>
          </div>`;
        body.appendChild(div);
      });
    }

    function filterUsers() {
      const q = document.getElementById('userSearch').value.toLowerCase();
      const role = document.getElementById('filterRole').value;
      const status = document.getElementById('filterStatus').value;
      const filtered = allUsers.filter(u => {
        const name = (u.first_name + ' ' + u.last_name + ' ' + u.email).toLowerCase();
        return name.includes(q) && (!role || u.role === role) && (!status || u.status === status);
      });
      renderList(filtered);
    }

    /* ── Select user ── */
    function selectUser(id) {
      selectedUserId = id;
      const u = allUsers.find(x => x.user_id === id);
      if (!u) return;
      document.querySelectorAll('.um-list-item').forEach(el => el.classList.toggle('active', +el.dataset.id === id));
      document.getElementById('emptyState').style.display = 'none';
      document.getElementById('umProfile').classList.add('visible');

      document.getElementById('profAvatar').textContent = initials(u);
      document.getElementById('profAvatar').style.background = u.color;
      document.getElementById('profName').textContent = u.first_name + ' ' + u.last_name;

      const rb = document.getElementById('profRoleBadge');
      rb.textContent = u.role; rb.className = 'badge-role ' + roleClass(u.role);

      const sb = document.getElementById('profStatusBadge');
      sb.innerHTML = `<span class="status-dot ${u.status === 'Active' ? 'status-active' : 'status-inactive'}"></span> ${u.status}`;
      sb.className = 'badge-status ' + (u.status === 'Active' ? 'badge-active' : 'badge-inactive');

      document.getElementById('profEmailVal').textContent = u.email;
      document.getElementById('profRoleVal').textContent = u.role;
      document.getElementById('profStatusVal').textContent = u.status;
      document.getElementById('profJoinedVal').textContent = u.created_at || '—';

    }
    /* ── Modal helpers ── */
    function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow = ''; }
    function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow = 'hidden'; }
    document.querySelectorAll('.modal-overlay').forEach(m => {
      m.addEventListener('click', e => { if (e.target === m) { m.classList.remove('active'); document.body.style.overflow = ''; } });
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') { document.querySelectorAll('.modal-overlay.active').forEach(m => m.classList.remove('active')); document.body.style.overflow = ''; }
    });

    /* ── Add user ── */
    function openAddModal() {
      ['addFirstName', 'addLastName', 'addEmail'].forEach(id => document.getElementById(id).value = '');
      document.getElementById('addRole').value = 'User';
      ['addFirstName', 'addLastName', 'addEmail'].forEach(id => document.getElementById(id).classList.remove('error'));
      ['addFirstNameErr', 'addLastNameErr', 'addEmailErr'].forEach(id => document.getElementById(id).style.display = 'none');
      openModal('addUserModal');
      document.getElementById('addPassword').value = '';
      document.getElementById('addPassword').classList.remove('error');
      document.getElementById('addPasswordErr').style.display = 'none';
      setTimeout(() => document.getElementById('addFirstName').focus(), 100);
    }

    /* ── Edit user ── */
    function openEditModal() {
      if (!selectedUserId) return;
      const u = allUsers.find(x => x.user_id == selectedUserId);
      document.getElementById('editFirstName').value = u.first_name;
      document.getElementById('editLastName').value = u.last_name;
      document.getElementById('editEmail').value = u.email;
      document.getElementById('editUserId').value = selectedUserId;

      ['editFirstName', 'editLastName', 'editEmail'].forEach(id => document.getElementById(id).classList.remove('error'));
      ['editFirstNameErr', 'editLastNameErr', 'editEmailErr'].forEach(id => document.getElementById(id).style.display = 'none');
      openModal('editUserModal');
      setTimeout(() => document.getElementById('editFirstName').focus(), 100);
    }

    /* ── Change role ── */
    function openRoleModal() {
      if (!selectedUserId) return;
      const u = allUsers.find(x => x.user_id === selectedUserId);
      document.getElementById('roleModalName').textContent = u.first_name + ' ' + u.last_name;
      document.getElementById('roleUserId').value = selectedUserId;
      document.getElementById('roleInput').value = u.role;
      document.querySelectorAll('.role-chip').forEach(chip => chip.classList.toggle('selected', chip.dataset.role === u.role));
      openModal('roleModal');
    }
    function selectRole(chip) {
      document.querySelectorAll('.role-chip').forEach(c => c.classList.remove('selected'));
      chip.classList.add('selected');
      document.getElementById('roleInput').value = chip.dataset.role;
    }
    /* ── Delete user ── */
    function openDeleteModal() {
      if (!selectedUserId) return;
      const u = allUsers.find(x => x.user_id === selectedUserId);
      document.getElementById('deleteModalName').textContent = u.first_name + ' ' + u.last_name;
      document.getElementById('deleteUserId').value = selectedUserId;
      openModal('deleteModal');
    }
    function openStatusModal() {
      if (!selectedUserId) return;
      const u = allUsers.find(x => x.user_id === selectedUserId);
      document.getElementById('statusModalName').textContent = u.first_name + ' ' + u.last_name;
      document.getElementById('statusUserId').value = selectedUserId;
      document.getElementById('statusInput').value = u.status;
      document.querySelectorAll('.status-chip').forEach(chip => chip.classList.toggle('selected', chip.dataset.status === u.status));
      openModal('statusModal');
    }
    function selectStatus(chip) {
      document.querySelectorAll('.status-chip').forEach(c => c.classList.remove('selected'));
      chip.classList.add('selected');
      document.getElementById('statusInput').value = chip.dataset.status;
    }

    /* ── Init ── */
    renderList(allUsers);
    document.getElementById('userCountBadge').textContent = allUsers.length ? '(' + allUsers.length + ')' : '';
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('success') === 'add') { showToast('User added successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }
    if (urlParams.get('success') === 'edit') { showToast('User updated successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }
    if (urlParams.get('success') === 'delete') { showToast('User deleted.'); window.history.replaceState({}, document.title, window.location.pathname); }
    if (urlParams.get('success') === 'role') { showToast('Role updated successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }
    if (urlParams.get('success') === 'status') { showToast('Status updated successfully!'); window.history.replaceState({}, document.title, window.location.pathname); }

  </script>
</body>

</html>