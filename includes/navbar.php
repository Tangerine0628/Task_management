<style>
  .caption-title {
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    color: #212529 !important;
  }

  .caption-sub-title {
    font-size: 0.75rem !important;
    color: #6c757d !important;
  }

  .custom-drop .nav-link {
    transition: transform 0.15s !important;
  }

  .custom-drop .nav-link:hover {
    transform: translateY(-1px) !important;
  }df
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
        <!-- User Profile -->
        <li class="nav-item dropdown custom-drop">
          <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <div class="caption ms-3 d-none d-md-block">
              <h6 class="mb-0 caption-title">
                <?= htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?>
              </h6>
              <p class="mb-0 caption-sub-title">
                <?= htmlspecialchars($currentUser['role']) ?>
              </p>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../login/logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>