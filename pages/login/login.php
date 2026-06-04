<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TaskFlow | Login</title>
  <link rel="shortcut icon" href="../../html/assets/images/favicon.ico">
  <link rel="stylesheet" href="../../html/assets/css/core/libs.min.css">
  <link rel="stylesheet" href="../../html/assets/css/hope-ui.min.css?v=5.0.0">
  <link rel="stylesheet" href="../../html/assets/css/custom.min.css?v=5.0.0">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      height: 100%;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background: #0f1f3d;
    }

    /* ── Page wrapper ── */
    .auth-page {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      background:
        radial-gradient(ellipse 70% 60% at 10% 10%, rgba(58,142,246,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 50% 50% at 90% 90%, rgba(30,90,180,0.2) 0%, transparent 55%),
        linear-gradient(145deg, #060f23 0%, #0d1f42 50%, #071530 100%);
    }

    /* ── Split card ── */
    .auth-card {
      display: flex;
      width: 100%;
      max-width: 860px;
      min-height: 520px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0,0,0,0.55), 0 0 0 1px rgba(255,255,255,0.06);
      animation: cardIn 0.45s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes cardIn {
      from { opacity:0; transform:translateY(28px) scale(0.97); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* ── LEFT PANEL ── */
    .auth-left {
      width: 42%;
      flex-shrink: 0;
      background: linear-gradient(160deg, #112358 0%, #1a3a6b 45%, #0d2b55 100%);
      padding: 48px 36px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    /* decorative blobs */
    .auth-left::before {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: rgba(58,142,246,0.15);
      top: -80px; right: -80px;
      filter: blur(60px);
    }
    .auth-left::after {
      content: '';
      position: absolute;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: rgba(30,90,200,0.18);
      bottom: -60px; left: -60px;
      filter: blur(50px);
    }

    /* floating circle decorations */
    .blob {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.08);
    }
    .blob-1 { width:110px; height:110px; top:18%; right:12%; }
    .blob-2 { width:70px;  height:70px;  top:48%; right:28%; }
    .blob-3 { width:50px;  height:50px;  bottom:28%; left:20%; }

    .auth-left-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      position: relative;
      z-index: 1;
    }
    .auth-left-logo-icon {
      width: 38px; height: 38px;
      border-radius: 10px;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.2);
      display: flex; align-items: center; justify-content: center;
    }
    .auth-left-logo-icon svg { width:20px; height:20px; color:#fff; }
    .auth-left-logo-name {
      font-size: 1.3rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.3px;
    }

    .auth-left-body {
      position: relative;
      z-index: 1;
    }
    .auth-left-title {
      font-size: 1.75rem;
      font-weight: 800;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 12px;
    }
    .auth-left-sub {
      font-size: 0.92rem;
      color: rgba(255,255,255,0.65);
      line-height: 1.6;
    }

    .auth-left-footer {
      position: relative;
      z-index: 1;
      font-size: 0.75rem;
      color: rgba(255,255,255,0.35);
    }

    /* ── RIGHT PANEL ── */
    .auth-right {
      flex: 1;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 48px 44px;
    }

    .auth-right-title {
      font-size: 1.5rem;
      font-weight: 800;
      color: #0f1f3d;
      margin-bottom: 6px;
    }
    .auth-right-sub {
      font-size: 0.875rem;
      color: #6b7280;
      margin-bottom: 28px;
    }

    /* ── Form fields ── */
    .field { margin-bottom: 18px; }
    .field-label-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 7px;
    }
    .field-label {
      font-size: 0.78rem;
      font-weight: 600;
      color: #374151;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .field-link {
      font-size: 0.78rem;
      color: #3a8ef6;
      text-decoration: none;
      font-weight: 500;
    }
    .field-link:hover { text-decoration: underline; }

    .input-wrap { position: relative; }
    .input-ico {
      position: absolute;
      left: 13px; top: 50%;
      transform: translateY(-50%);
      color: #c0c9d6;
      display: flex; align-items: center;
      pointer-events: none;
    }
    .input-ico svg { width:16px; height:16px; }

    .field-input {
      width: 100%;
      padding: 11px 14px 11px 40px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: 0.875rem;
      color: #1f2937;
      background: #f9fafb;
      outline: none;
      font-family: inherit;
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .field-input:focus {
      border-color: #3a8ef6;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(58,142,246,0.12);
    }
    .pw-toggle {
      position: absolute;
      right: 12px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none;
      cursor: pointer; color: #c0c9d6;
      display: flex; align-items: center;
      padding: 2px;
      transition: color 0.15s;
    }
    .pw-toggle:hover { color: #6b7280; }
    .pw-toggle svg { width:16px; height:16px; }

    .field-err {
      display: none;
      font-size: 0.75rem;
      color: #d63031;
      margin-top: 5px;
    }

    /* ── Remember me ── */
    .check-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 22px;
    }
    .check-row input[type="checkbox"] {
      width: 15px; height: 15px;
      accent-color: #3a8ef6;
      cursor: pointer;
    }
    .check-row label {
      font-size: 0.83rem;
      color: #6b7280;
      cursor: pointer;
    }

    /* ── Submit button ── */
    .btn-auth {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #1a3a6b 0%, #3a8ef6 100%);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 0.9rem;
      font-weight: 700;
      letter-spacing: 0.3px;
      cursor: pointer;
      box-shadow: 0 4px 16px rgba(26,58,107,0.35);
      transition: transform 0.15s, box-shadow 0.15s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-bottom: 20px;
    }
    .btn-auth:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(26,58,107,0.45);
    }
    .btn-auth svg { width:16px; height:16px; }
    .btn-spinner {
      display: none;
      width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,0.4);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── Divider ── */
    .divider {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1;
      height: 1px; background: #e9ecef;
    }
    .divider span { font-size: 0.75rem; color: #adb5bd; }

    /* ── Bottom link ── */
    .auth-bottom {
      text-align: center;
      font-size: 0.83rem;
      color: #6b7280;
    }
    .auth-bottom a {
      color: #1a3a6b;
      font-weight: 700;
      text-decoration: none;
    }
    .auth-bottom a:hover { text-decoration: underline; }

    /* ── Success alert ── */
    .alert-success {
      background: #e8f8f0;
      border: 1px solid #b7ebd4;
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 0.83rem;
      color: #27ae60;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* ── Responsive ── */
    @media (max-width: 680px) {
      .auth-card { flex-direction: column; max-width: 420px; }
      .auth-left { width: 100%; min-height: 180px; padding: 28px 28px 24px; }
      .auth-left-body { display: none; }
      .auth-right { padding: 32px 28px; }
      .blob { display: none; }
    }
  </style>
</head>
<body>

<div class="auth-page">
  <div class="auth-card">

    <!-- LEFT -->
    <div class="auth-left">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>
      <div class="blob blob-3"></div>

      <div class="auth-left-logo">
        <div class="auth-left-logo-icon">
          <svg viewBox="0 0 30 30" fill="none">
            <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
            <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
            <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
            <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
          </svg>
        </div>
        <span class="auth-left-logo-name">TaskFlow</span>
      </div>

      <div class="auth-left-body">
        <p class="auth-left-title">Welcome back.</p>
        <p class="auth-left-sub">Sign in to manage your tasks, track progress, and keep your team aligned — all in one place.</p>
      </div>

      <div class="auth-left-footer">© <script>document.write(new Date().getFullYear())</script> TaskFlow. All rights reserved.</div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
      <p class="auth-right-title">Sign In</p>
      <p class="auth-right-sub">Enter your credentials to continue.</p>

      <?php if (isset($_GET['reset'])): ?>
        <div class="alert-success">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
          Password updated! You can now sign in.
        </div>
      <?php endif; ?>

      <form id="loginForm" method="POST" action="ctrlData/ctrlLogin.php" novalidate>

        <!-- Email -->
        <div class="field">
          <div class="field-label-row">
            <label class="field-label" for="email">Email</label>
          </div>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </span>
            <input class="field-input" type="email" id="email" name="email" placeholder="you@example.com"
              autocomplete="email"
              value="<?php echo isset($_COOKIE['remember_email']) ? htmlspecialchars($_COOKIE['remember_email']) : ''; ?>"
              required>
          </div>
          <span class="field-err" id="emailErr">Please enter a valid email.</span>
        </div>

        <!-- Password -->
        <div class="field" style="margin-bottom:12px;">
          <div class="field-label-row">
            <label class="field-label" for="password">Password</label>
            <a href="forgot_password.php" class="field-link">Forgot password?</a>
          </div>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none">
                <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/>
                <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </span>
            <input class="field-input" type="password" id="password" name="password" placeholder="••••••••"
              autocomplete="current-password" required>
            <button type="button" class="pw-toggle" id="pwToggle" aria-label="Toggle password visibility">
              <svg id="eyeIcon" viewBox="0 0 24 24" fill="none">
                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
              </svg>
            </button>
          </div>
          <span class="field-err" id="passErr">Password is required.</span>
        </div>

        <!-- Remember me -->
        <div class="check-row">
          <input type="checkbox" id="rememberMe" name="remember_me">
          <label for="rememberMe">Remember me</label>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-auth" id="loginBtn">
          <div class="btn-spinner" id="btnSpinner"></div>
          <svg id="btnIcon" viewBox="0 0 24 24" fill="none">
            <path d="M15 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M10 17L15 12L10 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Login
        </button>

      </form>

      <div class="divider"><span>or</span></div>
      <div class="auth-bottom">Don't have an account? <a href="../register/register.php">Register</a></div>
    </div>

  </div>
</div>

<!-- Toast -->
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
    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
    <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  </svg>
  <span id="toastMsg">Invalid email or password.</span>
</div>

<script src="../../html/assets/js/core/libs.min.js"></script>
<script src="../../html/assets/js/hope-ui.js" defer></script>
<script>
  /* Password toggle */
  const pwToggle = document.getElementById('pwToggle');
  const pwField  = document.getElementById('password');
  const eyeIcon  = document.getElementById('eyeIcon');
  const eyeOpen   = `<path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>`;
  const eyeClosed = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>`;
  pwToggle.addEventListener('click', () => {
    const isHidden = pwField.type === 'password';
    pwField.type = isHidden ? 'text' : 'password';
    eyeIcon.innerHTML = isHidden ? eyeClosed : eyeOpen;
  });

  /* Validation + submit */
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    let valid = true;

    const emailErr = document.getElementById('emailErr');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      emailErr.style.display = 'block';
      document.getElementById('email').style.borderColor = '#d63031';
      valid = false;
    } else {
      emailErr.style.display = 'none';
      document.getElementById('email').style.borderColor = '';
    }

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

    const btn     = document.getElementById('loginBtn');
    const spinner = document.getElementById('btnSpinner');
    const icon    = document.getElementById('btnIcon');
    btn.disabled = true;
    spinner.style.display = 'block';
    icon.style.display = 'none';
    btn.childNodes[btn.childNodes.length - 1].textContent = ' Signing in...';
    this.submit();
  });

  ['email','password'].forEach(id => {
    document.getElementById(id).addEventListener('input', function() {
      this.style.borderColor = '';
      document.getElementById(id === 'email' ? 'emailErr' : 'passErr').style.display = 'none';
    });
  });

  /* Server-side error toast */
  <?php if (isset($_GET['error'])): ?>
    (function() {
      const msg = <?php echo json_encode($_GET['error']); ?>;
      document.getElementById('toastMsg').textContent = msg === 'inactive'
        ? 'Your account has been deactivated. Please contact an administrator.'
        : 'Incorrect email or password.';
      const toast = document.getElementById('toastNotify');
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
      setTimeout(() => { toast.style.opacity='0'; toast.style.transform='translateY(10px)'; }, 4000);
    })();
  <?php endif; ?>

  <?php if (isset($_COOKIE['remember_email'])): ?>
    document.getElementById('rememberMe').checked = true;
  <?php endif; ?>
</script>
</body>
</html>
