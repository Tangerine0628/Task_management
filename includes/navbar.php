<style>
  .navbar-user-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 10px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.15s;
    text-decoration: none;
    border: none;
    background: transparent;
  }

  .navbar-user-trigger:hover {
    background: rgba(0, 0, 0, 0.05);
  }

  .navbar-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #e8f0fe;
    color: #4e73df;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
    flex-shrink: 0;
  }

  .navbar-user-info {
    text-align: left;
    line-height: 1.2;
  }

  .navbar-user-name {
    font-size: 13px;
    font-weight: 600;
    color: #212529;
    margin: 0;
  }

  .navbar-user-role {
    font-size: 11px;
    color: #6c757d;
    margin: 0;
  }

  .navbar-chevron {
    font-size: 13px;
    color: #adb5bd;
    transition: transform 0.2s ease;
  }

  .navbar-user-trigger[aria-expanded="true"] .navbar-chevron {
    transform: rotate(180deg);
  }

  .user-dropdown-menu {
    min-width: 220px;
    padding: 0.4rem;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    margin-top: 6px !important;
  }

  .user-dropdown-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 10px 10px;
    border-bottom: 1px solid #f0f2f5;
    margin-bottom: 4px;
  }

  .user-dropdown-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #e8f0fe;
    color: #4e73df;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
    flex-shrink: 0;
  }

  .user-dropdown-fullname {
    font-size: 13px;
    font-weight: 600;
    color: #212529;
    margin: 0;
    line-height: 1.3;
  }

  .user-dropdown-email {
    font-size: 11px;
    color: #6c757d;
    margin: 0;
    line-height: 1.3;
  }

  .user-dropdown-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 13px;
    color: #343a40;
    text-decoration: none;
    transition: background 0.15s;
    cursor: pointer;
  }

  .user-dropdown-item:hover {
    background: #f8f9fa;
    color: #343a40;
  }

  .user-dropdown-item svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    color: #6c757d;
  }

  .user-dropdown-item.logout {
    color: #d63031;
  }

  .user-dropdown-item.logout svg {
    color: #d63031;
  }

  .user-dropdown-item.logout:hover {
    background: #fff0f0;
    color: #d63031;
  }

  .user-dropdown-divider {
    height: 1px;
    background: #f0f2f5;
    margin: 4px 0;
  }
</style>

<nav class="nav navbar navbar-expand-xl navbar-light iq-navbar">
  <div class="container-fluid navbar-inner">
    <a href="../dashboard/index.php" class="navbar-brand">
      <div class="logo-main">
        <div class="logo-normal">
          <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)"
              fill="currentColor" />
            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)"
              fill="currentColor" />
            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)"
              fill="currentColor" />
            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)"
              fill="currentColor" />
          </svg>
        </div>
        <div class="logo-mini">
          <svg class="text-primary icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)"
              fill="currentColor" />
            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)"
              fill="currentColor" />
            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)"
              fill="currentColor" />
            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)"
              fill="currentColor" />
          </svg>
        </div>
      </div>
      <h4 class="logo-title">TaskFlow</h4>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <span class="mt-2 navbar-toggler-bar bar1"></span>
        <span class="navbar-toggler-bar bar2"></span>
        <span class="navbar-toggler-bar bar3"></span>
      </span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">

        <li class="nav-item dropdown">
          <?php
          $firstName = htmlspecialchars($currentUser['first_name']);
          $lastName = htmlspecialchars($currentUser['last_name']);
          $email = htmlspecialchars($currentUser['email']);
          $role = htmlspecialchars($currentUser['role']);
          $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
          ?>
          <a class="navbar-user-trigger nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <div class="navbar-avatar"><?= $initials ?></div>
            <div class="navbar-user-info d-none d-md-block">
              <p class="navbar-user-name"><?= $firstName . ' ' . $lastName ?></p>
              <p class="navbar-user-role"><?= $role ?></p>
            </div>
            <svg class="navbar-chevron d-none d-md-block" viewBox="0 0 24 24" fill="none">
              <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </a>

          <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userDropdown">
            <li>
              <div class="user-dropdown-header">
                <div class="user-dropdown-avatar"><?= $initials ?></div>
                <div>
                  <p class="user-dropdown-fullname"><?= $firstName . ' ' . $lastName ?></p>
                  <p class="user-dropdown-email"><?= $email ?></p>
                </div>
              </div>
            </li>
            <li>
              <a class="user-dropdown-item logout" href="../login/logout.php">
                <svg viewBox="0 0 24 24" fill="none">
                  <path
                    d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                    stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M21 12H9" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
                Logout
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>