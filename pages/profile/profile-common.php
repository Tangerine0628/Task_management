<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TaskFlow | My Profile</title>

  <?php include '../../includes/link.php'; ?>

  <style>
    .sidebar-toggle {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      border-radius: 10px !important;
      transition: background 0.2s, color 0.2s !important;
      color: #94a3b8 !important;
    }

    .sidebar-toggle:hover {
      background: rgba(78, 115, 223, 0.1) !important;
      color: #4e73df !important;
    }

    .profile-avatar {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.14);
      overflow: hidden;
      position: relative;
    }

    .profile-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    /* Camera overlay on hover */
    .avatar-upload-wrap {
      position: relative;
      display: inline-block;
      cursor: pointer;
      flex-shrink: 0;
    }

    .avatar-upload-overlay {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      background: rgba(0,0,0,0.45);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.18s;
    }

    .avatar-upload-wrap:hover .avatar-upload-overlay {
      opacity: 1;
    }

    .avatar-upload-overlay svg {
      width: 22px;
      height: 22px;
      color: #fff;
    }

    .avatar-upload-input {
      display: none;
    }

    /* Remove photo button — lives inside the edit modal */
    .btn-remove-photo {
      margin-top: 6px;
      font-size: 0.78rem;
      color: #d63031;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
      text-decoration: underline;
      font-family: inherit;
      display: inline-flex;
      align-items: center;
    }
    .btn-remove-photo:hover { color: #b71c1c; }

    .profile-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 14px rgba(0, 0, 0, 0.07);
      overflow: hidden;
    }

    .profile-card-header {
      padding: 28px 28px 24px;
      border-bottom: 1px solid #f0f2f5;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 16px;
    }

    .profile-card-body {
      padding: 28px;
    }

    .info-section-title {
      font-size: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #4e73df;
      margin: 0 0 16px;
      padding-bottom: 8px;
      border-bottom: 2px solid #e8f0fe;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px 32px;
      margin-bottom: 28px;
    }

    .info-label {
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #adb5bd;
      margin: 0 0 4px;
    }

    .info-value {
      font-size: 0.9rem;
      color: #212529;
      font-weight: 500;
      margin: 0;
    }

    .badge-role {
      padding: 4px 14px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      display: inline-block;
    }

    .role-admin {
      background: #e8f0fe;
      color: #4e73df;
    }

    .role-user {
      background: #f3f4f6;
      color: #6c757d;
    }

    .badge-status {
      padding: 4px 14px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .status-active {
      background: #e8f8f0;
      color: #27ae60;
    }

    .status-inactive {
      background: #f3f4f6;
      color: #6c757d;
    }

    .status-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      display: inline-block;
    }

    .dot-active {
      background: #27ae60;
    }

    .dot-inactive {
      background: #adb5bd;
    }

    .btn-edit-profile {
      padding: 10px 22px;
      border-radius: 8px;
      border: none;
      background: linear-gradient(135deg, #4e73df 0%, #2b7de0 100%);
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(78, 115, 223, 0.35);
      transition: transform 0.15s ease, box-shadow 0.15s ease;
      text-decoration: none;
    }

    .btn-edit-profile:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(78, 115, 223, 0.45);
      color: #fff;
    }

    .btn-edit-profile svg {
      width: 16px;
      height: 16px;
    }

    .btn-logout {
      padding: 10px 22px;
      border-radius: 8px;
      border: 1.5px solid #ffd5d5;
      background: #fff0f0;
      color: #d63031;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: background 0.15s ease, color 0.15s ease, transform 0.15s ease;
      text-decoration: none;
    }

    .btn-logout:hover {
      background: #d63031;
      color: #fff;
      transform: translateY(-2px);
      border-color: #d63031;
    }

    .btn-logout svg {
      width: 16px;
      height: 16px;
    }

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
      max-width: 480px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
      overflow: hidden;
      animation: modalIn 0.2s ease;
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

    .form-input {
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

    .form-input:focus {
      border-color: #4e73df;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }

    .form-input.error {
      border-color: #d63031;
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

    .btn-submit-blue {
      padding: 9px 22px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(135deg, #4e73df, #2b7de0);
      color: #fff;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 4px 12px rgba(78, 115, 223, 0.35);
      transition: transform 0.15s, box-shadow 0.15s;
    }

    .btn-submit-blue:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(78, 115, 223, 0.45);
    }

    .btn-submit-blue svg {
      width: 15px;
      height: 15px;
    }

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

    @media (max-width: 576px) {
      .info-grid {
        grid-template-columns: 1fr;
      }

      .form-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body class="">
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>

  <?php
  $activePage = 'profile';
  include $sidebar_path;
  ?>

  <main class="main-content">
    <div class="position-relative iq-banner">

      <?php include '../../includes/navbar.php'; ?>

      <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                  <h1>My Profile</h1>
                  <p>View and manage your account information.</p>
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

    <div class="container-fluid content-inner mt-n5 py-0">
      <div class="row">
        <div class="col-12">
          <div class="profile-card">

            <div class="profile-card-header">
              <div class="d-flex align-items-center gap-3" style="gap: 20px;">
                <!-- Avatar — click to upload new photo -->
                <div class="avatar-upload-wrap" onclick="document.getElementById('avatarInput').click()" title="Change photo">
                  <div class="profile-avatar" id="profileAvatar"></div>
                  <div class="avatar-upload-overlay">
                    <svg viewBox="0 0 24 24" fill="none">
                      <path d="M23 19C23 19.5304 22.7893 20.0391 22.4142 20.4142C22.0391 20.7893 21.5304 21 21 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V8C1 7.46957 1.21071 6.96086 1.58579 6.58579C1.96086 6.21071 2.46957 6 3 6H7L9 3H15L17 6H21C21.5304 6 22.0391 6.21071 22.4142 6.58579C22.7893 6.96086 23 7.46957 23 8V19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <circle cx="12" cy="13" r="4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                  </div>
                  <input type="file" id="avatarInput" class="avatar-upload-input" accept="image/jpeg,image/png,image/webp,image/gif">
                </div>
                <div>
                  <h4 class="mb-1" id="profileName" style="font-weight:700;"></h4>
                  <p class="mb-1 text-muted" style="font-size:0.875rem;" id="profileEmail"></p>
                  <div class="d-flex gap-2 align-items-center mt-1" style="gap:8px;">
                    <span class="badge-role" id="profileRoleBadge"></span>
                    <span class="badge-status" id="profileStatusBadge"></span>
                  </div>
                </div>
              </div>
              <div class="d-flex gap-2" style="gap:10px;">
                <button class="btn-edit-profile" onclick="openEditModal()">
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
                <button class="btn-logout" onclick="confirmLogout()">
                  <svg viewBox="0 0 24 24" fill="none">
                    <path
                      d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                  Logout
                </button>
              </div>
            </div>

            <div class="profile-card-body">

              <p class="info-section-title">Account Information</p>
              <div class="info-grid">
                <div>
                  <p class="info-label">Role</p>
                  <p class="info-value" id="infoRole"></p>
                </div>
                <div>
                  <p class="info-label">Status</p>
                  <p class="info-value" id="infoStatus"></p>
                </div>
                <div>
                  <p class="info-label">Date Joined</p>
                  <p class="info-value" id="infoJoined"></p>
                </div>
                <div>
                  <p class="info-label">Last Updated</p>
                  <p class="info-value" id="infoUpdated"></p>
                </div>
              </div>

              <p class="info-section-title">Contact Information</p>
              <div class="info-grid">
                <div>
                  <p class="info-label">Email</p>
                  <p class="info-value" id="infoEmail"></p>
                </div>
                <div>
                  <p class="info-label">Full Name</p>
                  <p class="info-value" id="infoFullName"></p>
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
        <div class="right-panel">
          &copy;
          <script>document.write(new Date().getFullYear())</script> TaskFlow. All rights reserved.
        </div>
      </div>
    </footer>
  </main>

  <!-- EDIT PROFILE MODAL -->
  <div class="modal-overlay" id="editProfileModal" role="dialog" aria-modal="true">
    <div class="modal-card">
      <div class="modal-hdr">
        <p class="modal-hdr-title">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M11 4H4C3.44772 4 3 4.44772 3 5V20C3 20.5523 3.44772 21 4 21H19C19.5523 21 20 20.5523 20 19V12"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M18.5 2.5C19.3284 2.5 20 3.17157 20 4C20 4.82843 18.5 6.5 18.5 6.5L12 13L8 14L9 10L15.5 3.5C16.1272 2.87281 17.3284 2.5 18.5 2.5Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Edit Profile
        </p>
        <button class="modal-close" onclick="closeEditModal()">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <div class="modal-bdy">
        <div class="form-row">
          <div class="form-field">
            <label class="form-label">First Name <span style="color:#d63031;">*</span></label>
            <input class="form-input" type="text" id="editFirstName">
            <span class="form-error" id="editFirstNameErr">Required.</span>
          </div>
          <div class="form-field">
            <label class="form-label">Last Name <span style="color:#d63031;">*</span></label>
            <input class="form-input" type="text" id="editLastName">
            <span class="form-error" id="editLastNameErr">Required.</span>
          </div>
        </div>
        <div class="form-field">
          <label class="form-label">Email <span style="color:#d63031;">*</span></label>
          <input class="form-input" type="email" id="editEmail">
          <span class="form-error" id="editEmailErr">Enter a valid email.</span>
        </div>
        <!-- Only shown when the user has a profile photo -->
        <div id="removePhotoRow" style="display:none; margin-top:4px; padding-top:12px; border-top:1px solid #f0f2f5;">
          <button type="button" class="btn-remove-photo" onclick="removePhoto()">
            <svg viewBox="0 0 24 24" fill="none" style="width:13px;height:13px;margin-right:5px;vertical-align:middle;">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
              <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Remove profile photo
          </button>
        </div>
      </div>
      <div class="modal-ftr">
        <button class="btn-cancel-modal" onclick="closeEditModal()">Cancel</button>
        <button class="btn-submit-blue" onclick="saveProfile()">
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
    </div>
  </div>

  <!-- LOGOUT MODAL -->
  <div class="modal-overlay" id="logoutModal" role="dialog" aria-modal="true">
    <div class="modal-card" style="max-width:380px;">
      <div class="modal-hdr">
        <p class="modal-hdr-title">
          <svg viewBox="0 0 24 24" fill="none">
            <path
              d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Confirm Logout
        </p>
        <button class="modal-close" onclick="closeLogoutModal()">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>
      <div class="modal-bdy">
        <p style="font-size:0.9rem;color:#6c757d;margin:0;">Are you sure you want to logout? You'll need to sign in
          again to access your account.</p>
      </div>
      <div class="modal-ftr">
        <button class="btn-cancel-modal" onclick="closeLogoutModal()">Cancel</button>
        <button class="btn-submit-blue" style="background:linear-gradient(135deg,#d63031,#e17055);"
          onclick="window.location.href='../login/logout.php'">
          <svg viewBox="0 0 24 24" fill="none" style="width:15px;height:15px;">
            <path
              d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.96086 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Yes, Logout
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
    <span id="toastMsg">Profile updated!</span>
  </div>

  <?php include '../../includes/scripts.php'; ?>

  <script>
    let userData = {
      firstName: "<?= htmlspecialchars($currentUser['first_name']) ?>",
      lastName: "<?= htmlspecialchars($currentUser['last_name']) ?>",
      email: "<?= htmlspecialchars($currentUser['email']) ?>",
      role: "<?= htmlspecialchars($currentUser['role']) ?>",
      status: "<?= htmlspecialchars($currentUser['status']) ?>",
      joined: "<?= date('M d, Y', strtotime($currentUser['created_at'])) ?>",
      color: "#4e73df",
      profilePic: <?= !empty($currentUser['profile_pic']) ? json_encode('/task_management/uploads/avatars/' . $currentUser['profile_pic']) : 'null' ?>
    };

    function initials(u) {
      if (!u.firstName && !u.lastName) return '?';
      return ((u.firstName[0] || '') + (u.lastName[0] || '')).toUpperCase();
    }

    function showToast(msg, success = true) {
      const t = document.getElementById('toastNotify');
      t.style.borderLeftColor = success ? '#1cc88a' : '#d63031';
      t.querySelector('svg').style.color = success ? '#1cc88a' : '#d63031';
      document.getElementById('toastMsg').textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 3000);
    }

    function roleClass(role) {
      return role === 'Admin' ? 'role-admin' : 'role-user';
    }

    function renderProfile() {
      const fullName = (userData.firstName + ' ' + userData.lastName).trim() || 'No Name Set';

      const av = document.getElementById('profileAvatar');

      // Show photo if available, otherwise show initials
      if (userData.profilePic) {
        av.innerHTML = `<img src="${userData.profilePic}" alt="Profile photo">`;
        av.style.background = 'transparent';
      } else {
        av.textContent = initials(userData);
        av.style.background = userData.color;
      }

      document.getElementById('profileName').textContent = fullName;
      document.getElementById('profileEmail').textContent = userData.email || '—';

      const rb = document.getElementById('profileRoleBadge');
      rb.textContent = userData.role;
      rb.className = 'badge-role ' + roleClass(userData.role);

      const sb = document.getElementById('profileStatusBadge');
      sb.innerHTML = `<span class="status-dot ${userData.status === 'Active' ? 'dot-active' : 'dot-inactive'}"></span> ${userData.status}`;
      sb.className = 'badge-status ' + (userData.status === 'Active' ? 'status-active' : 'status-inactive');

      document.getElementById('infoRole').textContent = userData.role;
      document.getElementById('infoStatus').textContent = userData.status;
      document.getElementById('infoJoined').textContent = userData.joined;
      document.getElementById('infoUpdated').textContent = 'Today';
      document.getElementById('infoEmail').textContent = userData.email || '—';
      document.getElementById('infoFullName').textContent = fullName;
    }

    // Handle avatar file selection — upload immediately on change
    document.getElementById('avatarInput').addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;

      // Client-side size check (2MB)
      if (file.size > 2 * 1024 * 1024) {
        showToast('File is too large. Max 2MB.', false);
        this.value = '';
        return;
      }

      const formData = new FormData();
      formData.append('profile_pic', file);

      fetch('ctrlData/ctrl.upload.pfp.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Update the avatar preview immediately without a page reload
            userData.profilePic = '/task_management/uploads/avatars/' + data.filename;
            renderProfile();
            showToast('Profile photo updated!', true);
          } else {
            showToast(data.message || 'Upload failed.', false);
          }
        })
        .catch(() => showToast('Something went wrong.', false));

      // Reset input so the same file can be re-selected if needed
      this.value = '';
    });

    // Remove the current profile photo
    function removePhoto() {
      fetch('ctrlData/ctrl.remove.pfp.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            userData.profilePic = null;  // clear photo from local state
            renderProfile();             // revert avatar back to initials
            closeEditModal();            // close the modal
            showToast('Profile photo removed.', true);
          } else {
            showToast(data.message || 'Failed to remove photo.', false);
          }
        })
        .catch(() => showToast('Something went wrong.', false));
    }

    function openEditModal() {
      document.getElementById('editFirstName').value = userData.firstName;
      document.getElementById('editLastName').value = userData.lastName;
      document.getElementById('editEmail').value = userData.email;
      ['editFirstName', 'editLastName', 'editEmail'].forEach(id => document.getElementById(id).classList.remove('error'));
      ['editFirstNameErr', 'editLastNameErr', 'editEmailErr'].forEach(id => document.getElementById(id).style.display = 'none');

      // Show remove photo option only if the user has a photo
      document.getElementById('removePhotoRow').style.display = userData.profilePic ? 'block' : 'none';

      document.getElementById('editProfileModal').classList.add('active');
      document.body.style.overflow = 'hidden';
      setTimeout(() => document.getElementById('editFirstName').focus(), 100);
    }

    function closeEditModal() {
      document.getElementById('editProfileModal').classList.remove('active');
      document.body.style.overflow = '';
    }

    document.getElementById('editProfileModal').addEventListener('click', function (e) {
      if (e.target === this) closeEditModal();
    });

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeEditModal();
    });

    function saveProfile() {
      const fn = document.getElementById('editFirstName').value.trim();
      const ln = document.getElementById('editLastName').value.trim();
      const email = document.getElementById('editEmail').value.trim();
      let ok = true;

      const validate = (val, inputId, errId, test) => {
        const pass = test(val);
        document.getElementById(inputId).classList.toggle('error', !pass);
        document.getElementById(errId).style.display = pass ? 'none' : 'block';
        if (!pass) ok = false;
      };
      validate(fn, 'editFirstName', 'editFirstNameErr', v => v.length > 0);
      validate(ln, 'editLastName', 'editLastNameErr', v => v.length > 0);
      validate(email, 'editEmail', 'editEmailErr', v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v));
      if (!ok) return;

      const formData = new FormData();
      formData.append('first_name', fn);
      formData.append('last_name', ln);
      formData.append('email', email);

      fetch('ctrlData/ctrl.editprofile.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            closeEditModal();
            showToast('Profile updated successfully!', true);
            setTimeout(() => window.location.reload(), 1000);
          } else {
            showToast(data.message || 'Failed to update profile.', false);
          }
        })
        .catch(() => showToast('Something went wrong.', false));
    }

    function confirmLogout() {
      document.getElementById('logoutModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal() {
      document.getElementById('logoutModal').classList.remove('active');
      document.body.style.overflow = '';
    }

    document.getElementById('logoutModal').addEventListener('click', function (e) {
      if (e.target === this) closeLogoutModal();
    });

    document.addEventListener('DOMContentLoaded', renderProfile);
  </script>
</body>

</html>
