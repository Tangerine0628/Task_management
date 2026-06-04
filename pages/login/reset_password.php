<?php
session_start();
include '../../includes/conn.php';

$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if (!$token || !$email) {
    header('location: forgot_password.php');
    exit;
}

// Validate token
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
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
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
        }

        .page-bg {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            position: relative;
            overflow: hidden;
        }

        .page-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(59, 130, 246, 0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(99, 102, 241, 0.2) 0%, transparent 55%),
                linear-gradient(160deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            z-index: 0;
        }

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
        }

        .orb-2 {
            width: 280px;
            height: 280px;
            background: rgba(99, 102, 241, 0.15);
            bottom: -60px;
            right: -40px;
            animation-delay: -4s;
        }

        @keyframes drift {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(20px, -20px) scale(1.05);
            }
        }

        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: var(--card-radius);
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.15), 0 24px 64px rgba(0, 0, 0, 0.45);
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

        .card-tagline {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.75);
            margin: 4px 0 0;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 24px 28px 20px;
        }

        .form-field {
            margin-bottom: 16px;
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
        }

        .input-icon-right svg {
            width: 16px;
            height: 16px;
        }

        .form-input {
            width: 100%;
            padding: 10px 36px;
            border: 1.5px solid var(--slate-200);
            border-radius: var(--input-radius);
            font-family: var(--font-body);
            font-size: 0.875rem;
            color: var(--slate-800);
            background: var(--slate-50);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .form-input:focus {
            border-color: var(--blue-500);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .form-err {
            display: none;
            font-size: 0.72rem;
            color: #ef4444;
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            color: #fff;
            border: none;
            border-radius: var(--input-radius);
            font-family: var(--font-display);
            font-size: 0.925rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
            transition: transform 0.15s, box-shadow 0.15s;
            margin-bottom: 16px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.5);
        }

        .back-link {
            text-align: center;
            font-size: 0.82rem;
            color: var(--slate-500);
        }

        .back-link a {
            color: var(--blue-600);
            font-weight: 500;
            text-decoration: none;
        }

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
    </style>
</head>

<body>
    <div class="page-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="card">
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
                <p class="card-title">Reset your password</p>
                <p class="card-tagline">Enter your new password below</p>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['error'])): ?>
                    <div
                        style="padding:10px 14px;border-radius:8px;font-size:0.83rem;margin-bottom:16px;background:#fff0f0;border:1px solid #ffd5d5;color:#d63031;">
                        Passwords do not match or are too short.
                    </div>
                <?php endif; ?>
                <form method="POST" action="ctrlData/ctrl.resetpass.php">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="form-field">
                        <label class="form-label">New Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                            <input class="form-input" type="password" name="password" id="password"
                                placeholder="Min. 8 characters" required>
                            <button class="input-icon-right" type="button" onclick="togglePw('password', this)">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor"
                                        stroke-width="1.8" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-field">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                            <input class="form-input" type="password" name="confirm_password" id="confirm_password"
                                placeholder="Repeat password" required>
                            <button class="input-icon-right" type="button" onclick="togglePw('confirm_password', this)">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor"
                                        stroke-width="1.8" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Reset Password</button>
                </form>
                <p class="back-link"><a href="login.php">← Back to Login</a></p>
            </div>
            <div class="card-footer">
                <p>© 2026 TaskFlow. All rights reserved.</p>
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