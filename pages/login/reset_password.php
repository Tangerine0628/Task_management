<?php
// Start session and load DB connection
session_start();
include '../../includes/conn.php';

// Grab token and email from the URL
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

// Redirect if either is missing
if (!$token || !$email) {
    header('location: forgot_password.php');
    exit;
}

// Validate token: must exist, be unused, and not expired
$email_safe = mysqli_real_escape_string($conn, $email);
$token_safe = mysqli_real_escape_string($conn, $token);

$check = mysqli_query($conn, "SELECT * FROM tbl_passreset 
    WHERE token = '$token_safe' 
    AND email = '$email_safe' 
    AND used = 0 
    AND expires_at > NOW()");

if (mysqli_num_rows($check) === 0) {
    header('location: forgot_password.php?error=expired');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TaskFlow — Reset Password</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      min-height: 100vh;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background: #0f1f3d;
    }

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
      max-width: 800px;
      min-height: 480px;
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
    .auth-left::before {
      content: '';
      position: absolute;
      width: 280px; height: 280px; border-radius: 50%;
      background: rgba(58,142,246,0.14);
      top: -70px; right: -70px; filter: blur(55px);
    }
    .auth-left::after {
      content: '';
      position: absolute;
      width: 200px; height: 200px; border-radius: 50%;
      background: rgba(30,90,200,0.16);
      bottom: -50px; left: -50px; filter: blur(45px);
    }

    .blob { position:absolute; border-radius:50%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); }
    .blob-1 { width:100px; height:100px; top:20%; right:10%; }
    .blob-2 { width:65px;  height:65px;  top:55%; right:32%; }
    .blob-3 { width:45px;  height:45px;  bottom:22%; left:18%; }

    .auth-left-logo { display:flex; align-items:center; gap:10px; position:relative; z-index:1; }
    .auth-left-logo-icon {
      width:38px; height:38px; border-radius:10px;
      background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2);
      display:flex; align-items:center; justify-content:center;
    }
    .auth-left-logo-icon svg { width:20px; height:20px; color:#fff; }
    .auth-left-logo-name { font-size:1.3rem; font-weight:700; color:#fff; }

    .auth-left-body { position:relative; z-index:1; }
    .auth-left-title { font-size:1.65rem; font-weight:800; color:#fff; line-height:1.2; margin-bottom:12px; }
    .auth-left-sub { font-size:0.88rem; color:rgba(255,255,255,0.6); line-height:1.65; }

    /* password strength hints */
    .pw-hints { margin-top:22px; display:flex; flex-direction:column; gap:9px; }
    .pw-hint { display:flex; align-items:center; gap:10px; }
    .pw-hint-dot { width:7px; height:7px; border-radius:50%; background:rgba(58,142,246,0.7); flex-shrink:0; }
    .pw-hint span { font-size:0.81rem; color:rgba(255,255,255,0.5); }

    .auth-left-footer { position:relative; z-index:1; font-size:0.74rem; color:rgba(255,255,255,0.3); }

    /* ── RIGHT PANEL ── */
    .auth-right {
      flex: 1;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 48px 48px;
    }
    .auth-right-title { font-size:1.45rem; font-weight:800; color:#0f1f3d; margin-bottom:4px; }
    .auth-right-sub   { font-size:0.875rem; color:#6b7280; margin-bottom:26px; line-height:1.6; }

    /* ── Error alert ── */
    .alert-error {
      padding: 11px 14px;
      border-radius: 9px;
      font-size: 0.83rem;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 9px;
      background: #fff0f0;
      border: 1px solid #ffd5d5;
      color: #d63031;
    }
    .alert-error svg { width:15px; height:15px; flex-shrink:0; }

    /* ── Fields ── */
    .field { margin-bottom: 16px; }
    .field-label {
      display:block; font-size:0.73rem; font-weight:600;
      color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:7px;
    }
    .input-wrap { position:relative; }
    .input-ico {
      position:absolute; left:12px; top:50%; transform:translateY(-50%);
      color:#c0c9d6; pointer-events:none; display:flex; align-items:center;
    }
    .input-ico svg { width:15px; height:15px; }
    .input-ico-right {
      position:absolute; right:12px; top:50%; transform:translateY(-50%);
      background:none; border:none; cursor:pointer; color:#c0c9d6;
      display:flex; align-items:center; padding:2px;
      transition:color 0.15s;
    }
    .input-ico-right:hover { color:#6b7280; }
    .input-ico-right svg { width:15px; height:15px; }

    .field-input {
      width:100%; padding:11px 40px;
      border:1.5px solid #e5e7eb; border-radius:9px;
      font-size:0.875rem; color:#1f2937; background:#f9fafb;
      outline:none; font-family:inherit;
      transition:border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .field-input::placeholder { color:#d1d5db; }
    .field-input:focus { border-color:#1a3a6b; background:#fff; box-shadow:0 0 0 3px rgba(26,58,107,0.1); }

    /* ── Button ── */
    .btn-auth {
      width:100%; padding:12px;
      background:linear-gradient(135deg, #112358 0%, #3a8ef6 100%);
      color:#fff; border:none; border-radius:10px;
      font-size:0.9rem; font-weight:700; letter-spacing:0.3px;
      cursor:pointer; box-shadow:0 4px 16px rgba(17,35,88,0.35);
      transition:transform 0.15s, box-shadow 0.15s;
      margin-bottom:18px;
    }
    .btn-auth:hover { transform:translateY(-1px); box-shadow:0 8px 24px rgba(17,35,88,0.45); }

    /* ── Back link ── */
    .back-link { text-align:center; font-size:0.83rem; color:#6b7280; }
    .back-link a { color:#1a3a6b; font-weight:600; text-decoration:none; }
    .back-link a:hover { text-decoration:underline; }

    @media (max-width:640px) {
      .auth-card { flex-direction:column; max-width:420px; }
      .auth-left { width:100%; min-height:160px; padding:24px; }
      .auth-left-body { display:none; }
      .auth-right { padding:32px 24px; }
      .blob { display:none; }
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
        <p class="auth-left-title">Set a new password.</p>
        <p class="auth-left-sub">Choose a strong password to keep your account secure.</p>
        <div class="pw-hints">
          <div class="pw-hint"><div class="pw-hint-dot"></div><span>At least 8 characters long</span></div>
          <div class="pw-hint"><div class="pw-hint-dot"></div><span>Both fields must match</span></div>
          <div class="pw-hint"><div class="pw-hint-dot"></div><span>Reset link is single-use only</span></div>
        </div>
      </div>

      <div class="auth-left-footer">© <script>document.write(new Date().getFullYear())</script> TaskFlow. All rights reserved.</div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
      <p class="auth-right-title">Reset Password</p>
      <p class="auth-right-sub">Enter your new password below. It must be at least 8 characters.</p>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert-error">
          <svg viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
            <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Passwords do not match or are too short. Please try again.
        </div>
      <?php endif; ?>

      <form method="POST" action="ctrlData/ctrl.resetpass.php">
        <!-- Pass token and email through hidden inputs -->
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <!-- New password -->
        <div class="field">
          <label class="field-label" for="password">New Password</label>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none">
                <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </span>
            <input class="field-input" type="password" name="password" id="password" placeholder="Min. 8 characters" required>
            <button class="input-ico-right" type="button" onclick="togglePw('password', this)" aria-label="Show password">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Confirm password -->
        <div class="field">
          <label class="field-label" for="confirm_password">Confirm Password</label>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none">
                <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </span>
            <input class="field-input" type="password" name="confirm_password" id="confirm_password" placeholder="Repeat your password" required>
            <button class="input-ico-right" type="button" onclick="togglePw('confirm_password', this)" aria-label="Show confirm password">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-auth">Reset Password</button>
      </form>

      <p class="back-link"><a href="login.php">← Back to Login</a></p>
    </div>

  </div>
</div>

<script>
  function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const svg = btn.querySelector('svg');
    if (inp.type === 'password') {
      inp.type = 'text';
      svg.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>`;
    } else {
      inp.type = 'password';
      svg.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>`;
    }
  }
</script>
</body>
</html>
