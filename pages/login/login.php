<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TaskFlow | Login</title>
  <link rel="shortcut icon" href="../../html/assets/images/favicon.ico">
  <link rel="stylesheet" href="../../html/assets/css/core/libs.min.css">
  <link rel="stylesheet" href="../../html/assets/css/hope-ui.min.css?v=5.0.0">
  <link rel="stylesheet" href="../../html/assets/css/custom.min.css?v=5.0.0">

  <style>
    /* ── Full page layout ── */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .login-page {
      min-height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      overflow: hidden;
    }

    /* ── Background ── */
    .login-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, #0f1f3d 0%, #1a3a6b 40%, #0d2b55 70%, #0a1e3d 100%);
      z-index: 0;
    }

    /* decorative circles */
    .login-bg::before {
      content: '';
      position: absolute;
      width: 600px;
      height: 600px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(58, 142, 246, 0.18) 0%, transparent 70%);
      top: -150px;
      right: -100px;
    }

    .login-bg::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(43, 125, 224, 0.15) 0%, transparent 70%);
      bottom: -100px;
      left: -80px;
    }

    /* subtle grid pattern */
    .login-bg-grid {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
      background-size: 48px 48px;
    }

    /* ── Card ── */
    .login-card {
      position: relative;
      z-index: 1;
      background: #ffffff;
      border-radius: 18px;
      width: 100%;
      max-width: 400px;
      overflow: hidden;
      box-shadow:
        0 32px 64px rgba(0, 0, 0, 0.35),
        0 0 0 0.5px rgba(255, 255, 255, 0.08);
      animation: cardIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    @keyframes cardIn {
      from {
        opacity: 0;
        transform: translateY(28px) scale(0.96);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* ── Card Header ── */
    .card-header-area {
      background: linear-gradient(135deg, #1a3a6b 0%, #2b5faa 100%);
      padding: 28px 28px 22px;
      text-align: center;
    }

    .brand {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 12px;
    }

    .brand-icon {
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .brand-icon svg {
      width: 20px;
      height: 20px;
      color: #fff;
    }

    .brand-name {
      font-size: 1.25rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.3px;
    }

    .card-header-title {
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.75);
      margin: 0;
      font-weight: 400;
    }

    /* ── Card Body ── */
    .card-body-area {
      padding: 26px 28px 20px;
    }

    /* ── Form ── */
    .form-group {
      margin-bottom: 18px;
    }

    .form-group:last-of-type {
      margin-bottom: 0;
    }

    .form-label-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 6px;
    }

    .form-lbl {
      font-size: 0.78rem;
      font-weight: 600;
      color: #374151;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .forgot-link {
      font-size: 0.78rem;
      color: #3a8ef6;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.15s;
    }

    .forgot-link:hover {
      color: #2b7de0;
      text-decoration: underline;
    }

    .input-wrap {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #adb5bd;
      display: flex;
      align-items: center;
    }

    .input-icon svg {
      width: 16px;
      height: 16px;
    }

    .form-control-custom {
      width: 100%;
      padding: 10px 12px 10px 38px;
      border: 1.5px solid #e5e7eb;
      border-radius: 9px;
      font-size: 0.875rem;
      color: #1f2937;
      background: #f9fafb;
      outline: none;
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
      font-family: inherit;
    }

    .form-control-custom:focus {
      border-color: #3a8ef6;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(58, 142, 246, 0.12);
    }

    /* password toggle */
    .pw-toggle {
      position: absolute;
      right: 11px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #adb5bd;
      padding: 2px;
      display: flex;
      align-items: center;
      transition: color 0.15s;
    }

    .pw-toggle:hover {
      color: #6b7280;
    }

    .pw-toggle svg {
      width: 16px;
      height: 16px;
    }

    /* ── Remember me ── */
    .remember-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
    }

    .remember-row input[type="checkbox"] {
      width: 15px;
      height: 15px;
      accent-color: #3a8ef6;
      cursor: pointer;
    }

    .remember-row label {
      font-size: 0.83rem;
      color: #6b7280;
      cursor: pointer;
      user-select: none;
    }

    /* ── Login button ── */
    .btn-login {
      width: 100%;
      padding: 11px;
      background: linear-gradient(135deg, #3a8ef6 0%, #2b7de0 100%);
      color: #fff;
      border: none;
      border-radius: 9px;
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0.2px;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(58, 142, 246, 0.38);
      transition: transform 0.15s ease, box-shadow 0.15s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-bottom: 18px;
    }

    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(58, 142, 246, 0.48);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login svg {
      width: 16px;
      height: 16px;
    }

    /* ── Divider ── */
    .divider {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }

    .divider-line {
      flex: 1;
      height: 0.5px;
      background: #e5e7eb;
    }

    .divider-text {
      font-size: 0.75rem;
      color: #adb5bd;
    }

    /* ── Register link ── */
    .register-row {
      text-align: center;
      font-size: 0.83rem;
      color: #6b7280;
    }

    .register-row a {
      color: #3a8ef6;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s;
    }

    .register-row a:hover {
      color: #2b7de0;
      text-decoration: underline;
    }

    /* ── Card Footer ── */
    .card-footer-area {
      padding: 12px 28px;
      border-top: 0.5px solid #f0f2f5;
      background: #fafbfc;
      text-align: center;
    }

    .card-footer-area p {
      font-size: 0.73rem;
      color: #adb5bd;
      margin: 0;
    }

    /* ── Error alert (hidden by default) ── */
    .alert-error {
      display: none;
      background: #fff0f0;
      border: 1px solid #ffd5d5;
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 0.83rem;
      color: #d63031;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .alert-error svg {
      width: 15px;
      height: 15px;
      flex-shrink: 0;
    }

    .alert-error.hidden {
      display: none !important;
    }

    /* ── Loading spinner on button ── */
    .btn-spinner {
      display: none;
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.4);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body>

  <div class="login-page">

    <!-- Background -->
    <div class="login-bg">
      <div class="login-bg-grid"></div>
    </div>

    <!-- Login Card -->
    <div class="login-card">

      <!-- Header -->
      <div class="card-header-area">
        <div class="brand">
          <div class="brand-icon">
            <svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
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
          <span class="brand-name">TaskFlow</span>
        </div>
        <p class="card-header-title">Sign in to your account</p>
      </div>

      <!-- Body -->
      <div class="card-body-area">

        <?php if (isset($_GET['reset'])): ?>
          <div class="alert-success">
            Password updated! You can now sign in.
          </div>
        <?php endif; ?>

        <!--
          PHP: show this block if login fails
          <?php if (isset($error)): ?>
        -->
          <div class="alert-error hidden" id="loginError">
            <svg viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
              <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span id="loginErrorMsg">Invalid email or password. Please try again.</span>
          </div>
          <!--
          PHP: <?php endif; ?>
        -->

        <!-- Login Form -->
        <!--
          PHP: action="login.php" method="POST"
        -->
        <form id="loginForm" method="POST" action="ctrlData/ctrlLogin.php" novalidate>

          <!-- Email -->
          <div class="form-group">
            <label class="form-lbl" for="email">Email</label>
            <div class="input-wrap">
              <span class="input-icon">
                <svg viewBox="0 0 24 24" fill="none">
                  <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </span>
              <input class="form-control-custom" type="email" id="email" name="email" placeholder="you@example.com"
                autocomplete="email"
                value="<?php echo isset($_COOKIE['remember_email']) ? htmlspecialchars($_COOKIE['remember_email']) : ''; ?>"
                required>
            </div>
            <span class="field-error" id="emailErr"
              style="display:none;font-size:0.75rem;color:#d63031;margin-top:4px;">Please enter a valid email.</span>
          </div>

          <!-- Password -->
          <div class="form-group" style="margin-bottom:12px;">
            <div class="form-label-row">
              <label class="form-lbl" for="password">Password</label>
              <a href="forgot_password.php" class="forgot-link">Forgot password?</a>
            </div>
            <div class="input-wrap">
              <span class="input-icon">
                <svg viewBox="0 0 24 24" fill="none">
                  <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8" />
                  <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" />
                </svg>
              </span>
              <input class="form-control-custom" type="password" id="password" name="password" placeholder="••••••••"
                autocomplete="current-password" required>
              <button type="button" class="pw-toggle" id="pwToggle" aria-label="Toggle password visibility">
                <svg id="eyeIcon" viewBox="0 0 24 24" fill="none">
                  <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
                </svg>
              </button>
            </div>
            <span class="field-error" id="passErr"
              style="display:none;font-size:0.75rem;color:#d63031;margin-top:4px;">Password is required.</span>
          </div>

          <!-- Remember me -->
          <div class="remember-row">
            <input type="checkbox" id="rememberMe" name="remember_me">
            <label for="rememberMe">Remember me</label>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn-login" id="loginBtn">
            <div class="btn-spinner" id="btnSpinner"></div>
            <svg id="btnIcon" viewBox="0 0 24 24" fill="none">
              <path d="M15 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H15" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M10 17L15 12L10 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Login
          </button>

        </form>

        <!-- Divider -->
        <div class="divider">
          <div class="divider-line"></div>
          <span class="divider-text">or</span>
          <div class="divider-line"></div>
        </div>

        <!-- Register -->
        <div class="register-row">
          Don't have an account? <a href="../register/register.php">Register</a>
        </div>

      </div>

      <!-- Footer -->
      <div class="card-footer-area">
        <p>&copy;
          <script>document.write(new Date().getFullYear())</script> TaskFlow. All rights reserved.
        </p>
      </div>

    </div><!-- end login-card -->
  </div>

  <!-- Hope UI scripts (optional for auth page — keep if you need the loader) -->
  <script src="../../html/assets/js/core/libs.min.js"></script>
  <script src="../../html/assets/js/hope-ui.js" defer></script>

  <script>
    /* ── Password visibility toggle ── */
    const pwToggle = document.getElementById('pwToggle');
    const pwField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const eyeOpen = `<path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>`;
    const eyeClosed = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>`;

    pwToggle.addEventListener('click', () => {
      const isHidden = pwField.type === 'password';
      pwField.type = isHidden ? 'text' : 'password';
      eyeIcon.innerHTML = isHidden ? eyeClosed : eyeOpen;
    });

    /* ── Client-side validation + loading state ── */
    document.getElementById('loginForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;
      let valid = true;

      /* validate email */
      const emailErr = document.getElementById('emailErr');
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        emailErr.style.display = 'block';
        document.getElementById('email').style.borderColor = '#d63031';
        valid = false;
      } else {
        emailErr.style.display = 'none';
        document.getElementById('email').style.borderColor = '';
      }

      /* validate password */
      const passErr = document.getElementById('passErr');
      if (!password) {
        passErr.style.display = 'block';
        document.getElementById('password').style.borderColor = '#d63031';
        valid = false;
      } else {
        passErr.style.display = 'none';
        document.getElementById('password').style.borderColor = '';
      }

      if (!valid) return;

      /* show loading state */
      const btn = document.getElementById('loginBtn');
      const spinner = document.getElementById('btnSpinner');
      const icon = document.getElementById('btnIcon');
      btn.disabled = true;
      spinner.style.display = 'block';
      icon.style.display = 'none';
      btn.childNodes[btn.childNodes.length - 1].textContent = ' Signing in...';

      this.submit();
    });

    /* clear error on input */
    ['email', 'password'].forEach(id => {
      document.getElementById(id).addEventListener('input', function () {
        this.style.borderColor = '';
        document.getElementById(id === 'email' ? 'emailErr' : 'passErr').style.display = 'none';
        document.getElementById('loginError').classList.add('hidden');
      });
    });
  </script>

  <div id="toastNotify" style="
    position:fixed; bottom:28px; right:28px;
    background:#fff; border:1px solid #e9ecef;
    border-left:4px solid #d63031;
    border-radius:10px; padding:12px 18px;
    font-size:0.875rem; color:#212529; font-weight:500;
    box-shadow:0 8px 24px rgba(0,0,0,0.1);
    display:flex; align-items:center; gap:10px;
    z-index:99999; opacity:0; transform:translateY(10px);
    pointer-events:none; transition:opacity 0.25s ease, transform 0.25s ease;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="color:#d63031;flex-shrink:0;">
      <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
      <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
    </svg>
    <span id="toastMsg">Invalid email or password.</span>
  </div>

  <?php if (isset($_GET['error'])): ?>
    <script>
      const msg = <?php echo json_encode($_GET['error']); ?>;
      document.getElementById('toastMsg').textContent = msg === 'inactive'
        ? 'Your account has been deactivated. Please contact an administrator.'
        : 'Incorrect email or password.';
      const toast = document.getElementById('toastNotify');
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
      setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateY(10px)'; }, 4000);
    </script>
  <?php endif; ?>

  <?php if (isset($_COOKIE['remember_email'])): ?>
    <script>
      document.getElementById('rememberMe').checked = true;
    </script>
  <?php endif; ?>

</body>

</html>