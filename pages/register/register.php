<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TaskFlow — Create Account</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
    rel="stylesheet">

  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --blue-50: #eff6ff;
      --blue-100: #dbeafe;
      --blue-400: #60a5fa;
      --blue-500: #3b82f6;
      --blue-600: #2563eb;
      --blue-700: #1d4ed8;
      --slate-50: #f8fafc;
      --slate-100: #f1f5f9;
      --slate-200: #e2e8f0;
      --slate-300: #cbd5e1;
      --slate-400: #94a3b8;
      --slate-500: #64748b;
      --slate-600: #475569;
      --slate-700: #334155;
      --slate-800: #1e293b;
      --slate-900: #0f172a;
      --card-radius: 20px;
      --input-radius: 10px;
      --font-display: 'Bricolage Grotesque', sans-serif;
      --font-body: 'DM Sans', sans-serif;
    }

    html,
    body {
      min-height: 100vh;
      font-family: var(--font-body);
      background: var(--slate-900);
      color: var(--slate-800);
    }

    /* ── Full-page background ── */
    .page-bg {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
      position: relative;
      overflow: hidden;
    }

    /* Mesh gradient background */
    .page-bg::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 80% 60% at 20% 10%, rgba(59, 130, 246, 0.25) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 80% 80%, rgba(99, 102, 241, 0.2) 0%, transparent 55%),
        radial-gradient(ellipse 50% 70% at 60% 20%, rgba(14, 165, 233, 0.12) 0%, transparent 50%),
        linear-gradient(160deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
      z-index: 0;
    }

    /* Subtle grid overlay */
    .page-bg::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(99, 102, 241, 0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99, 102, 241, 0.06) 1px, transparent 1px);
      background-size: 48px 48px;
      z-index: 0;
    }

    /* Floating orbs */
    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      pointer-events: none;
      z-index: 0;
      animation: drift 12s ease-in-out infinite alternate;
    }

    .orb-1 {
      width: 380px;
      height: 380px;
      background: rgba(59, 130, 246, 0.18);
      top: -80px;
      left: -60px;
      animation-delay: 0s;
    }

    .orb-2 {
      width: 280px;
      height: 280px;
      background: rgba(99, 102, 241, 0.15);
      bottom: -60px;
      right: -40px;
      animation-delay: -4s;
    }

    .orb-3 {
      width: 200px;
      height: 200px;
      background: rgba(14, 165, 233, 0.12);
      top: 40%;
      left: 60%;
      animation-delay: -8s;
    }

    @keyframes drift {
      from {
        transform: translate(0, 0) scale(1);
      }

      to {
        transform: translate(20px, -20px) scale(1.05);
      }
    }

    /* ── Card ── */
    .card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 400px;
      background: rgba(255, 255, 255, 0.97);
      border-radius: var(--card-radius);
      box-shadow:
        0 0 0 1px rgba(255, 255, 255, 0.15),
        0 24px 64px rgba(0, 0, 0, 0.45),
        0 4px 16px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      animation: cardIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes cardIn {
      from {
        opacity: 0;
        transform: translateY(24px) scale(0.97);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* ── Card header ── */
    .card-header {
      padding: 28px 28px 20px;
      background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 60%, #60a5fa 100%);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .card-header::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 160px;
      height: 160px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.07);
    }

    .card-header::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -30px;
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
    }

    .logo-row {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 12px;
      position: relative;
      z-index: 1;
    }

    .logo-icon {
      width: 36px;
      height: 36px;
      border-radius: 9px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .logo-icon svg {
      width: 20px;
      height: 20px;
      color: #fff;
    }

    .logo-name {
      font-family: var(--font-display);
      font-size: 1.35rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.3px;
    }

    .card-tagline {
      font-size: 0.82rem;
      color: rgba(255, 255, 255, 0.75);
      font-weight: 300;
      margin: 0;
      position: relative;
      z-index: 1;
      letter-spacing: 0.2px;
    }

    .card-title {
      font-family: var(--font-display);
      font-size: 1.05rem;
      font-weight: 600;
      color: #fff;
      margin: 4px 0 0;
      position: relative;
      z-index: 1;
    }

    /* ── Card body ── */
    .card-body {
      padding: 24px 28px 20px;
    }

    /* ── Form ── */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 14px;
    }

    .form-field {
      margin-bottom: 14px;
    }

    .form-field:last-of-type {
      margin-bottom: 0;
    }

    .form-label {
      display: block;
      font-size: 0.72rem;
      font-weight: 500;
      color: var(--slate-500);
      text-transform: uppercase;
      letter-spacing: 0.55px;
      margin-bottom: 5px;
    }

    .input-wrap {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 11px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      color: var(--slate-400);
      pointer-events: none;
    }

    .input-icon-right {
      position: absolute;
      right: 11px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      color: var(--slate-400);
      cursor: pointer;
      background: none;
      border: none;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.15s;
    }

    .input-icon-right:hover {
      color: var(--slate-600);
    }

    .input-icon-right svg {
      width: 16px;
      height: 16px;
    }

    .form-input {
      width: 100%;
      padding: 10px 12px;
      border: 1.5px solid var(--slate-200);
      border-radius: var(--input-radius);
      font-family: var(--font-body);
      font-size: 0.875rem;
      color: var(--slate-800);
      background: var(--slate-50);
      outline: none;
      transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
      -webkit-appearance: none;
    }

    .form-input.has-icon {
      padding-left: 36px;
    }

    .form-input.has-icon-right {
      padding-right: 36px;
    }

    .form-input::placeholder {
      color: var(--slate-300);
    }

    .form-input:focus {
      border-color: var(--blue-500);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }

    .form-input.error {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-err {
      display: none;
      font-size: 0.72rem;
      color: #ef4444;
      margin-top: 4px;
    }

    /* ── Terms ── */
    .terms-row {
      display: flex;
      align-items: flex-start;
      gap: 9px;
      margin-bottom: 18px;
    }

    .terms-checkbox {
      width: 16px;
      height: 16px;
      border-radius: 4px;
      border: 1.5px solid var(--slate-300);
      flex-shrink: 0;
      margin-top: 1px;
      cursor: pointer;
      accent-color: var(--blue-600);
      transition: border-color 0.15s;
    }

    .terms-checkbox:focus {
      outline: 2px solid rgba(59, 130, 246, 0.35);
      outline-offset: 2px;
    }

    .terms-text {
      font-size: 0.8rem;
      color: var(--slate-500);
      line-height: 1.5;
    }

    .terms-text a {
      color: var(--blue-600);
      text-decoration: none;
      font-weight: 500;
    }

    .terms-text a:hover {
      text-decoration: underline;
    }

    .terms-err {
      display: none;
      font-size: 0.72rem;
      color: #ef4444;
      margin-top: 3px;
    }

    /* ── Register Button ── */
    .btn-register {
      width: 100%;
      padding: 11px;
      background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
      color: #fff;
      border: none;
      border-radius: var(--input-radius);
      font-family: var(--font-display);
      font-size: 0.925rem;
      font-weight: 600;
      letter-spacing: 0.2px;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
      transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-bottom: 16px;
    }

    .btn-register:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 22px rgba(37, 99, 235, 0.5);
    }

    .btn-register:active {
      transform: translateY(0);
    }

    .btn-register svg {
      width: 16px;
      height: 16px;
    }

    .btn-register .spinner {
      display: none;
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.35);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* ── Divider ── */
    .divider {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--slate-200);
    }

    .divider span {
      font-size: 0.75rem;
      color: var(--slate-400);
      white-space: nowrap;
    }

    /* ── Login link ── */
    .login-link {
      text-align: center;
      font-size: 0.82rem;
      color: var(--slate-500);
    }

    .login-link a {
      color: var(--blue-600);
      font-weight: 500;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    /* ── Card Footer ── */
    .card-footer {
      padding: 12px 28px;
      border-top: 1px solid var(--slate-100);
      background: var(--slate-50);
      text-align: center;
    }

    .card-footer p {
      font-size: 0.72rem;
      color: var(--slate-400);
    }

    /* ── Success state ── */
    .success-state {
      display: none;
      padding: 32px 28px;
      text-align: center;
    }

    .success-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(135deg, #22c55e, #16a34a);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      box-shadow: 0 8px 24px rgba(34, 197, 94, 0.35);
      animation: popIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes popIn {
      from {
        transform: scale(0.5);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .success-icon svg {
      width: 28px;
      height: 28px;
      color: #fff;
    }

    .success-title {
      font-family: var(--font-display);
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--slate-800);
      margin: 0 0 6px;
    }

    .success-sub {
      font-size: 0.85rem;
      color: var(--slate-500);
      line-height: 1.6;
    }

    /* ── Field animation ── */
    .form-field,
    .form-row,
    .terms-row,
    .btn-register,
    .divider,
    .login-link {
      animation: fadeUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .form-row {
      animation-delay: 0.08s;
    }

    .form-field:nth-child(2) {
      animation-delay: 0.12s;
    }

    .form-field:nth-child(3) {
      animation-delay: 0.16s;
    }

    .form-field:nth-child(4) {
      animation-delay: 0.20s;
    }

    .terms-row {
      animation-delay: 0.24s;
    }

    .btn-register {
      animation-delay: 0.28s;
    }

    .divider {
      animation-delay: 0.30s;
    }

    .login-link {
      animation-delay: 0.32s;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(12px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 440px) {
      .card {
        border-radius: 16px;
      }

      .card-body {
        padding: 20px 20px 16px;
      }

      .card-header {
        padding: 22px 20px 16px;
      }

      .card-footer {
        padding: 10px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="page-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="card" role="main">

      <!-- Header -->
      <div class="card-header">
        <div class="logo-row">
          <div class="logo-icon">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M9 11L11 13L15 9" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                stroke-linejoin="round" />
              <path
                d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
          </div>
          <span class="logo-name">TaskFlow</span>
        </div>
        <p class="card-title">Create your account</p>
        <p class="card-tagline">Manage tasks and teams, all in one place</p>
      </div>

      <!-- Body -->
      <div class="card-body" id="formBody">

        <div class="form-row">
          <div>
            <label class="form-label" for="firstName">First Name</label>
            <input class="form-input" type="text" id="firstName" name="first_name" placeholder="Austin"
              autocomplete="given-name">
            <p class="form-err" id="firstNameErr">Required.</p>
          </div>
          <div>
            <label class="form-label" for="lastName">Last Name</label>
            <input class="form-input" type="text" id="lastName" name="last_name" placeholder="Robertson"
              autocomplete="family-name">
            <p class="form-err" id="lastNameErr">Required.</p>
          </div>
        </div>

        <div class="form-field">
          <label class="form-label" for="email">Email</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
              <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
              <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <input class="form-input has-icon" type="email" id="email" name="email" placeholder="you@company.com"
              autocomplete="email">
          </div>
          <p class="form-err" id="emailErr">Enter a valid email address.</p>
        </div>

        <div class="form-field">
          <label class="form-label" for="password">Password</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="currentColor" stroke-width="1.8" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
            <input class="form-input has-icon has-icon-right" type="password" id="password" name="password"
              placeholder="Min. 8 characters" autocomplete="new-password">
            <button class="input-icon-right" type="button" onclick="togglePw('password', this)"
              aria-label="Show password">
              <svg id="eyeIcon1" viewBox="0 0 24 24" fill="none">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8" />
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
              </svg>
            </button>
          </div>
          <p class="form-err" id="passwordErr">Password must be at least 8 characters.</p>
        </div>

        <div class="form-field">
          <label class="form-label" for="confirmPassword">Confirm Password</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="currentColor" stroke-width="1.8" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
            <input class="form-input has-icon has-icon-right" type="password" id="confirmPassword"
              name="confirm_password" placeholder="Repeat your password" autocomplete="new-password">
            <button class="input-icon-right" type="button" onclick="togglePw('confirmPassword', this)"
              aria-label="Show confirm password">
              <svg id="eyeIcon2" viewBox="0 0 24 24" fill="none">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8" />
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
              </svg>
            </button>
          </div>
          <p class="form-err" id="confirmPasswordErr">Passwords do not match.</p>
        </div>

        <div class="terms-row">
          <input class="terms-checkbox" type="checkbox" id="terms">
          <div>
            <label class="terms-text" for="terms">
              I agree to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>
            </label>
            <p class="terms-err" id="termsErr">You must agree to continue.</p>
          </div>
        </div>

        <button class="btn-register" onclick="handleRegister()" id="registerBtn" type="button">
          <div class="spinner" id="spinner"></div>
          <svg id="btnIcon" viewBox="0 0 24 24" fill="none">
            <path
              d="M16 11C18.2091 11 20 9.20914 20 7C20 4.79086 18.2091 3 16 3M16 11C13.7909 11 12 9.20914 12 7C12 4.79086 13.7909 3 16 3M16 3V1M9 14C5.13401 14 2 17.134 2 21H16"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M19 14L21 16L25 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
            <circle cx="20" cy="17" r="4" stroke="currentColor" stroke-width="2" />
            <path d="M18.5 17L19.5 18L21.5 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          <span id="btnLabel">Create Account</span>
        </button>

        <div class="divider"><span>or</span></div>

        <p class="login-link">Already have an account? <a href="../login/login.php">Login</a></p>

        <!-- Success state (hidden, shown after submit) -->
        <div class="success-state" id="successState">
          <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </div>
          <p class="success-title">Account created!</p>
          <p class="success-sub">Welcome to TaskFlow.<br>Redirecting you to the dashboard…</p>
        </div>

      </div>

      <!-- Footer -->
      <div class="card-footer">
        <p>© 2026 TaskFlow. All rights reserved.</p>
      </div>

    </div>
  </div>

  <script>
    /* ── Show / hide password ── */
    function togglePw(inputId, btn) {
      const inp = document.getElementById(inputId);
      const svg = btn.querySelector('svg');
      if (inp.type === 'password') {
        inp.type = 'text';
        // Crossed-out eye
        svg.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>`;
      } else {
        inp.type = 'password';
        svg.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>`;
      }
    }

    /* ── Validation ── */
    function setErr(inputId, errId, show) {
      const inp = document.getElementById(inputId);
      const err = document.getElementById(errId);
      if (show) { inp.classList.add('error'); err.style.display = 'block'; }
      else { inp.classList.remove('error'); err.style.display = 'none'; }
    }

    function validate() {
      let ok = true;
      const fn = document.getElementById('firstName').value.trim();
      const ln = document.getElementById('lastName').value.trim();
      const em = document.getElementById('email').value.trim();
      const pw = document.getElementById('password').value;
      const cpw = document.getElementById('confirmPassword').value;
      const tms = document.getElementById('terms').checked;

      setErr('firstName', 'firstNameErr', !fn);
      setErr('lastName', 'lastNameErr', !ln);
      setErr('email', 'emailErr', !em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em));
      setErr('password', 'passwordErr', pw.length < 8);
      setErr('confirmPassword', 'confirmPasswordErr', !cpw || cpw !== pw);

      const termsErr = document.getElementById('termsErr');
      if (!tms) { termsErr.style.display = 'block'; ok = false; } else { termsErr.style.display = 'none'; }

      if (!fn || !ln) ok = false;
      if (!em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) ok = false;
      if (pw.length < 8) ok = false;
      if (!cpw || cpw !== pw) ok = false;

      return ok;
    }

    /* ── Clear errors on input ── */
    ['firstName', 'lastName', 'email', 'password', 'confirmPassword'].forEach(id => {
      document.getElementById(id).addEventListener('input', () => {
        document.getElementById(id).classList.remove('error');
        const errEl = document.getElementById(id + 'Err') || document.getElementById(id.charAt(0).toUpperCase() + id.slice(1) + 'Err');
      });
    });

    /* ── Submit ── */
    function handleRegister() {
      if (!validate()) return;

      const btn = document.getElementById('registerBtn');
      const spinner = document.getElementById('spinner');
      const icon = document.getElementById('btnIcon');
      const label = document.getElementById('btnLabel');

      // Loading state
      btn.disabled = true;
      btn.style.opacity = '0.85';
      spinner.style.display = 'block';
      icon.style.display = 'none';
      label.textContent = 'Creating account…';

      // Simulate async registration
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'ctrlData/ctrl.register.php';

      ['first_name', 'last_name', 'email', 'password'].forEach(name => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = document.getElementById(
          name === 'first_name' ? 'firstName' :
            name === 'last_name' ? 'lastName' : name
        ).value;
        form.appendChild(input);
      });

      document.body.appendChild(form);
      form.submit();
    }

    /* Clear term error on check */
    document.getElementById('terms').addEventListener('change', () => {
      if (document.getElementById('terms').checked) {
        document.getElementById('termsErr').style.display = 'none';
      }
    });
  </script>
</body>

</html>