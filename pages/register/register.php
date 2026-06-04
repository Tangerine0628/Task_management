<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TaskFlow — Create Account</title>
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
      max-width: 900px;
      min-height: 580px;
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
      width: 38%;
      flex-shrink: 0;
      background: linear-gradient(160deg, #112358 0%, #1a3a6b 45%, #0d2b55 100%);
      padding: 48px 32px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }
    .auth-left::before {
      content: '';
      position: absolute;
      width: 280px; height: 280px;
      border-radius: 50%;
      background: rgba(58,142,246,0.14);
      top: -70px; right: -70px;
      filter: blur(55px);
    }
    .auth-left::after {
      content: '';
      position: absolute;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: rgba(30,90,200,0.16);
      bottom: -50px; left: -50px;
      filter: blur(45px);
    }
    .blob { position:absolute; border-radius:50%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); }
    .blob-1 { width:100px; height:100px; top:20%; right:10%; }
    .blob-2 { width:65px;  height:65px;  top:52%; right:30%; }
    .blob-3 { width:45px;  height:45px;  bottom:25%; left:18%; }

    .auth-left-logo { display:flex; align-items:center; gap:10px; position:relative; z-index:1; }
    .auth-left-logo-icon {
      width:38px; height:38px; border-radius:10px;
      background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2);
      display:flex; align-items:center; justify-content:center;
    }
    .auth-left-logo-icon svg { width:20px; height:20px; color:#fff; }
    .auth-left-logo-name { font-size:1.3rem; font-weight:700; color:#fff; letter-spacing:-0.3px; }

    .auth-left-body { position:relative; z-index:1; }
    .auth-left-title { font-size:1.65rem; font-weight:800; color:#fff; line-height:1.2; margin-bottom:12px; }
    .auth-left-sub { font-size:0.88rem; color:rgba(255,255,255,0.6); line-height:1.65; }

    .auth-left-perks { margin-top:24px; display:flex; flex-direction:column; gap:10px; }
    .perk { display:flex; align-items:center; gap:10px; }
    .perk-dot { width:7px; height:7px; border-radius:50%; background:rgba(58,142,246,0.8); flex-shrink:0; }
    .perk span { font-size:0.82rem; color:rgba(255,255,255,0.55); }

    .auth-left-footer { position:relative; z-index:1; font-size:0.74rem; color:rgba(255,255,255,0.3); }

    /* ── RIGHT PANEL ── */
    .auth-right {
      flex:1;
      background:#fff;
      display:flex;
      flex-direction:column;
      justify-content:center;
      padding: 40px 44px;
      overflow-y: auto;
    }
    .auth-right-title { font-size:1.45rem; font-weight:800; color:#0f1f3d; margin-bottom:4px; }
    .auth-right-sub   { font-size:0.875rem; color:#6b7280; margin-bottom:22px; }

    /* ── Form ── */
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px; }
    .field { margin-bottom:14px; }
    .field-label {
      display:block; font-size:0.73rem; font-weight:600;
      color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;
    }
    .input-wrap { position:relative; }
    .input-ico {
      position:absolute; left:12px; top:50%; transform:translateY(-50%);
      color:#c0c9d6; display:flex; align-items:center; pointer-events:none;
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
      width:100%; padding:10px 14px 10px 36px;
      border:1.5px solid #e5e7eb; border-radius:9px;
      font-size:0.875rem; color:#1f2937; background:#f9fafb;
      outline:none; font-family:inherit;
      transition:border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .field-input.has-right { padding-right:36px; }
    .field-input::placeholder { color:#d1d5db; }
    .field-input:focus { border-color:#1a3a6b; background:#fff; box-shadow:0 0 0 3px rgba(26,58,107,0.1); }
    .field-input.error { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,0.1); }
    .field-err { display:none; font-size:0.72rem; color:#ef4444; margin-top:4px; }

    /* Terms */
    .terms-row { display:flex; align-items:flex-start; gap:9px; margin-bottom:18px; }
    .terms-checkbox { width:15px; height:15px; accent-color:#1a3a6b; cursor:pointer; margin-top:2px; flex-shrink:0; }
    .terms-text { font-size:0.8rem; color:#6b7280; line-height:1.5; }
    .terms-text a { color:#1a3a6b; font-weight:600; text-decoration:none; }
    .terms-text a:hover { text-decoration:underline; }
    .terms-err { display:none; font-size:0.72rem; color:#ef4444; margin-top:3px; }

    /* Submit */
    .btn-auth {
      width:100%; padding:12px;
      background:linear-gradient(135deg, #112358 0%, #3a8ef6 100%);
      color:#fff; border:none; border-radius:10px;
      font-size:0.9rem; font-weight:700; letter-spacing:0.3px;
      cursor:pointer; box-shadow:0 4px 16px rgba(17,35,88,0.35);
      transition:transform 0.15s, box-shadow 0.15s;
      display:flex; align-items:center; justify-content:center; gap:8px;
      margin-bottom:16px;
    }
    .btn-auth:hover { transform:translateY(-1px); box-shadow:0 8px 24px rgba(17,35,88,0.45); }
    .btn-auth .spinner {
      display:none; width:16px; height:16px;
      border:2px solid rgba(255,255,255,0.4); border-top-color:#fff;
      border-radius:50%; animation:spin 0.7s linear infinite;
    }
    @keyframes spin { to { transform:rotate(360deg); } }

    /* Divider */
    .divider { display:flex; align-items:center; gap:10px; margin-bottom:14px; }
    .divider::before,.divider::after { content:''; flex:1; height:1px; background:#e9ecef; }
    .divider span { font-size:0.75rem; color:#adb5bd; }

    /* Bottom link */
    .auth-bottom { text-align:center; font-size:0.83rem; color:#6b7280; }
    .auth-bottom a { color:#1a3a6b; font-weight:700; text-decoration:none; }
    .auth-bottom a:hover { text-decoration:underline; }

    /* Success state */
    .success-state { display:none; padding:24px 0; text-align:center; }
    .success-icon {
      width:56px; height:56px; border-radius:50%;
      background:linear-gradient(135deg,#22c55e,#16a34a);
      display:flex; align-items:center; justify-content:center;
      margin:0 auto 14px;
      box-shadow:0 8px 24px rgba(34,197,94,0.35);
      animation:popIn 0.4s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes popIn { from{transform:scale(0.5);opacity:0;} to{transform:scale(1);opacity:1;} }
    .success-icon svg { width:26px; height:26px; color:#fff; }
    .success-title { font-size:1.05rem; font-weight:700; color:#0f1f3d; margin-bottom:6px; }
    .success-sub { font-size:0.85rem; color:#6b7280; line-height:1.6; }

    @media (max-width:680px) {
      .auth-card { flex-direction:column; max-width:420px; }
      .auth-left { width:100%; min-height:160px; padding:24px; }
      .auth-left-body { display:none; }
      .auth-right { padding:28px 24px; }
      .blob { display:none; }
      .form-row { grid-template-columns:1fr; }
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
        <p class="auth-left-title">Join your team today.</p>
        <p class="auth-left-sub">Create your account and start managing tasks with your team in minutes.</p>
        <div class="auth-left-perks">
          <div class="perk"><div class="perk-dot"></div><span>Assign and track tasks in real time</span></div>
          <div class="perk"><div class="perk-dot"></div><span>Full activity history on every task</span></div>
          <div class="perk"><div class="perk-dot"></div><span>Role-based access for your whole team</span></div>
        </div>
      </div>

      <div class="auth-left-footer">© <script>document.write(new Date().getFullYear())</script> TaskFlow. All rights reserved.</div>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
      <div id="formBody">
        <p class="auth-right-title">Create Account</p>
        <p class="auth-right-sub">Fill in your details to get started.</p>

        <!-- Name row -->
        <div class="form-row">
          <div>
            <label class="field-label" for="firstName">First Name</label>
            <input class="field-input" type="text" id="firstName" placeholder="Austin" autocomplete="given-name">
            <p class="field-err" id="firstNameErr">Required.</p>
          </div>
          <div>
            <label class="field-label" for="lastName">Last Name</label>
            <input class="field-input" type="text" id="lastName" placeholder="Robertson" autocomplete="family-name">
            <p class="field-err" id="lastNameErr">Required.</p>
          </div>
        </div>

        <!-- Email -->
        <div class="field">
          <label class="field-label" for="email">Email</label>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none"><path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <input class="field-input" type="email" id="email" placeholder="you@company.com" autocomplete="email">
          </div>
          <p class="field-err" id="emailErr">Enter a valid email address.</p>
        </div>

        <!-- Password -->
        <div class="field">
          <label class="field-label" for="password">Password</label>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <input class="field-input has-right" type="password" id="password" placeholder="Min. 8 characters" autocomplete="new-password">
            <button class="input-ico-right" type="button" onclick="togglePw('password', this)" aria-label="Show password">
              <svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
            </button>
          </div>
          <p class="field-err" id="passwordErr">Password must be at least 8 characters.</p>
        </div>

        <!-- Confirm password -->
        <div class="field">
          <label class="field-label" for="confirmPassword">Confirm Password</label>
          <div class="input-wrap">
            <span class="input-ico">
              <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </span>
            <input class="field-input has-right" type="password" id="confirmPassword" placeholder="Repeat your password" autocomplete="new-password">
            <button class="input-ico-right" type="button" onclick="togglePw('confirmPassword', this)" aria-label="Show confirm password">
              <svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
            </button>
          </div>
          <p class="field-err" id="confirmPasswordErr">Passwords do not match.</p>
        </div>

        <!-- Terms -->
        <div class="terms-row">
          <input class="terms-checkbox" type="checkbox" id="terms">
          <div>
            <label class="terms-text" for="terms">I agree to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a></label>
            <p class="terms-err" id="termsErr">You must agree to continue.</p>
          </div>
        </div>

        <button class="btn-auth" onclick="handleRegister()" id="registerBtn" type="button">
          <div class="spinner" id="spinner"></div>
          <span id="btnLabel">Create Account</span>
        </button>

        <div class="divider"><span>or</span></div>
        <div class="auth-bottom">Already have an account? <a href="../login/login.php">Login</a></div>

        <!-- Success state -->
        <div class="success-state" id="successState">
          <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
          </div>
          <p class="success-title">Account created!</p>
          <p class="success-sub">Welcome to TaskFlow.<br>Redirecting you to login…</p>
        </div>
      </div>
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
  <span id="toastMsg"></span>
</div>

<script>
  function togglePw(inputId, btn) {
    const inp = document.getElementById(inputId);
    const svg = btn.querySelector('svg');
    if (inp.type === 'password') {
      inp.type = 'text';
      svg.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>`;
    } else {
      inp.type = 'password';
      svg.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>`;
    }
  }

  function setErr(inputId, errId, show) {
    const inp = document.getElementById(inputId);
    const err = document.getElementById(errId);
    if (show) { inp.classList.add('error'); err.style.display = 'block'; }
    else       { inp.classList.remove('error'); err.style.display = 'none'; }
  }

  function validate() {
    let ok = true;
    const fn  = document.getElementById('firstName').value.trim();
    const ln  = document.getElementById('lastName').value.trim();
    const em  = document.getElementById('email').value.trim();
    const pw  = document.getElementById('password').value;
    const cpw = document.getElementById('confirmPassword').value;
    const tms = document.getElementById('terms').checked;

    setErr('firstName',       'firstNameErr',       !fn);
    setErr('lastName',        'lastNameErr',        !ln);
    setErr('email',           'emailErr',           !em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em));
    setErr('password',        'passwordErr',        pw.length < 8);
    setErr('confirmPassword', 'confirmPasswordErr', !cpw || cpw !== pw);

    const termsErr = document.getElementById('termsErr');
    if (!tms) { termsErr.style.display = 'block'; ok = false; } else { termsErr.style.display = 'none'; }
    if (!fn || !ln) ok = false;
    if (!em || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) ok = false;
    if (pw.length < 8) ok = false;
    if (!cpw || cpw !== pw) ok = false;
    return ok;
  }

  ['firstName','lastName','email','password','confirmPassword'].forEach(id => {
    document.getElementById(id).addEventListener('input', () => document.getElementById(id).classList.remove('error'));
  });
  document.getElementById('terms').addEventListener('change', () => {
    if (document.getElementById('terms').checked) document.getElementById('termsErr').style.display = 'none';
  });

  function handleRegister() {
    if (!validate()) return;
    const btn     = document.getElementById('registerBtn');
    const spinner = document.getElementById('spinner');
    const label   = document.getElementById('btnLabel');
    btn.disabled = true;
    btn.style.opacity = '0.85';
    spinner.style.display = 'block';
    label.textContent = 'Creating account…';

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'ctrlData/ctrl.register.php';
    ['first_name','last_name','email','password'].forEach(name => {
      const input = document.createElement('input');
      input.type  = 'hidden';
      input.name  = name;
      input.value = document.getElementById(
        name === 'first_name' ? 'firstName' : name === 'last_name' ? 'lastName' : name
      ).value;
      form.appendChild(input);
    });
    document.body.appendChild(form);
    form.submit();
  }

  function showToast(msg) {
    const toast = document.getElementById('toastNotify');
    document.getElementById('toastMsg').textContent = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
    setTimeout(() => { toast.style.opacity='0'; toast.style.transform='translateY(10px)'; }, 4000);
  }

  <?php if (isset($_GET['error'])): ?>
    document.addEventListener('DOMContentLoaded', () => {
      <?php if ($_GET['error'] === 'email'): ?>
        showToast('That email address is already registered. Please use a different one.');
      <?php elseif ($_GET['error'] === 'failed'): ?>
        showToast('Registration failed. Please try again.');
      <?php endif; ?>
    });
  <?php endif; ?>
</script>
</body>
</html>
