<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
  <div class="sidebar-header d-flex align-items-center justify-content-start">
    <a href="../dashboard/index.php" class="navbar-brand">
      <!--Logo start-->
      <div class="logo-main">
        <div class="logo-normal">
          <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
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
          <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
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
      <!--logo End-->
      <h4 class="logo-title">TaskFlow</h4>
    </a>
    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
      <i class="icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
            stroke-linejoin="round" />
          <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </i>
    </div>
  </div>
  <div class="sidebar-body pt-0 data-scrollbar">
    <div class="sidebar-list">
      <!-- Sidebar Menu Start -->
      <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
        <li class="nav-item static-item">
          <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
          </a>
        </li>
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>" href="../dashboard/index.php">
            <i class="icon">
              <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path opacity="0.4"
                  d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z"
                  fill="currentColor"></path>
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z"
                  fill="currentColor"></path>
              </svg>
            </i>
            <span class="item-name">Dashboard</span>
          </a>
        </li>
        <li>
          <hr class="hr-horizontal">
        </li>
        <!-- Task Management -->
        <li class="nav-item">
          <a class="nav-link <?php echo $activePage === 'tasks' ? 'active' : ''; ?>" href="../tasks/task.management.php">
            <i class="icon">
              <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4"
                  d="M8 3C8 2.44772 8.44772 2 9 2H15C15.5523 2 16 2.44772 16 3V4C16 4.55228 15.5523 5 15 5H9C8.44772 5 8 4.55228 8 4V3Z"
                  fill="currentColor" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M6 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4H18C18 5.65685 16.6569 7 15 7H9C7.34315 7 6 5.65685 6 4ZM7 11C7 10.4477 7.44772 10 8 10C8.55228 10 9 10.4477 9 11C9 11.5523 8.55228 12 8 12C7.44772 12 7 11.5523 7 11ZM8 14C7.44772 14 7 14.4477 7 15C7 15.5523 7.44772 16 8 16C8.55228 16 9 15.5523 9 15C9 14.4477 8.55228 14 8 14ZM11 11C11 10.4477 11.4477 10 12 10H16C16.5523 10 17 10.4477 17 11C17 11.5523 16.5523 12 16 12H12C11.4477 12 11 11.5523 11 11ZM12 14C11.4477 14 11 14.4477 11 15C11 15.5523 11.4477 16 12 16H16C16.5523 16 17 15.5523 17 15C17 14.4477 16.5523 14 16 14H12Z"
                  fill="currentColor" />
              </svg>
            </i>
            <span class="item-name">Task Management</span>
          </a>
        </li>
        <!-- User Management -->
        <li class="nav-item">
          <a class="nav-link <?php echo $activePage === 'users' ? 'active' : ''; ?>" href="../users/user.management.php">
            <i class="icon">
              <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4"
                  d="M15.5 8C15.5 10.2091 13.7091 12 11.5 12C9.29086 12 7.5 10.2091 7.5 8C7.5 5.79086 9.29086 4 11.5 4C13.7091 4 15.5 5.79086 15.5 8Z"
                  fill="currentColor" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M11.5 14C7.35786 14 4 17.3579 4 21.5C4 21.7761 4.22386 22 4.5 22H18.5C18.7761 22 19 21.7761 19 21.5C19 17.3579 15.6421 14 11.5 14Z"
                  fill="currentColor" />
                <path opacity="0.4"
                  d="M17.5 6C17.5 7.65685 16.1569 9 14.5 9C14.3177 9 14.1393 8.98287 13.9664 8.95013C14.2912 8.36381 14.5 7.7044 14.5 7C14.5 5.96064 14.1409 5.00598 13.5386 4.25604C13.8398 4.09082 14.1594 4 14.5 4C16.1569 4 17.5 5.34315 17.5 6Z"
                  fill="currentColor" />
                <path
                  d="M18.5 11C16.8431 11 15.5 9.65685 15.5 8C15.5 8 16.3177 8.95013 16.9664 8.95013C17.8579 8.95013 18.5 8.20939 18.5 7.5C18.5 7.5 19.5 8.34315 19.5 9.5C19.5 10.3284 19.0523 11 18.5 11ZM20 13C18.8954 13 18 13 17 13.5C18.3431 14.5 19.5 16.2 19.9 18H22.5C22.7761 18 23 17.7761 23 17.5C23 15.0147 21.7614 13 20 13Z"
                  fill="currentColor" />
              </svg>
            </i>
            <span class="item-name">User Management</span>
          </a>
        </li>
        <li>
          <hr class="hr-horizontal">
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $activePage === 'profile' ? 'active' : ''; ?>" href="../profile/user.profile.php">
            <i class="icon">
              <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none">
                <path opacity="0.4"
                  d="M12 2C9.38 2 7.25 4.13 7.25 6.75C7.25 9.32 9.26 11.4 11.88 11.49C11.96 11.48 12.04 11.48 12.1 11.49C14.72 11.4 16.73 9.32 16.75 6.75C16.75 4.13 14.62 2 12 2Z"
                  fill="currentColor" />
                <path
                  d="M17.08 14.15C14.29 12.29 9.74 12.29 6.93 14.15C5.66 15 4.96 16.15 4.96 17.38C4.96 18.61 5.66 19.75 6.92 20.59C8.32 21.53 10.16 22 12 22C13.84 22 15.68 21.53 17.08 20.59C18.34 19.74 19.04 18.6 19.04 17.36C19.03 16.13 18.34 14.99 17.08 14.15Z"
                  fill="currentColor" />
              </svg>
            </i>
            <span class="item-name">Profile</span>
          </a>
        </li>

      </ul>
      <!-- Sidebar Menu End -->
    </div>
  </div>
  <div class="sidebar-footer"></div>
</aside>