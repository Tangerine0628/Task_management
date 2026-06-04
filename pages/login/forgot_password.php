<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskFlow — Forgot Password</title>
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
            --slate-300: #cbd5e1;
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
            color: var(--slate-800);
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
            margin-bottom: 18px;
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

        .form-input {
            width: 100%;
            padding: 10px 12px 10px 36px;
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

        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.83rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error {
            background: #fff0f0;
            border: 1px solid #ffd5d5;
            color: #d63031;
        }

        .alert-success {
            background: #e8f8f0;
            border: 1px solid #b7ebd4;
            color: #27ae60;
        }

        .alert svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
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

        .back-link a:hover {
            text-decoration: underline;
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
                <p class="card-title">Forgot your password?</p>
                <p class="card-tagline">We'll send a reset link to your email</p>
            </div>

            <div class="card-body">

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                            <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Email not found in our system.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['sent'])): ?>
                    <div class="alert alert-success">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                        Reset link sent! Check your inbox.
                    </div>
                <?php endif; ?>

                <form method="POST" action="ctrlData/ctrl.frgtpass.php">
                    <div class="form-field">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z"
                                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" />
                            </svg>
                            <input class="form-input" type="email" id="email" name="email" placeholder="you@example.com"
                                required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Send Reset Link</button>
                </form>

                <p class="back-link"><a href="login.php">← Back to Login</a></p>
            </div>

            <div class="card-footer">
                <p>© 2026 TaskFlow. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>