<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskFlow — {{ __('Email Verification') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237c6af7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M9 11l3 3L22 4'/%3E%3Cpath d='M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11'/%3E%3C/svg%3E">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --c-bg: #0f0f13;
            --c-surface: #18181f;
            --c-border: #2a2a35;
            --c-accent: #7c6af7;
            --c-accent-light: #a89fff;
            --c-text: #e8e8f0;
            --c-text-light: #64748b;
            --c-muted: #8888a0;
            --c-success: #22c55e;
            --c-danger: #ef4444;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--c-bg) 0%, #1a1a24 100%);
            color: var(--c-text);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--c-accent) 0%, var(--c-accent-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.15);
        }

        .profile-avatar svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .profile-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--c-text);
            margin-bottom: 4px;
        }

        .profile-email {
            font-size: 0.875rem;
            color: var(--c-text-light);
        }

        .brand-section {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--c-accent);
            margin-bottom: 4px;
            letter-spacing: -0.025em;
        }

        .brand-tagline {
            font-size: 0.875rem;
            color: var(--c-text-light);
            font-weight: 400;
        }

        .message {
            color: var(--c-text);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 32px;
            text-align: center;
        }

        .status-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .status-message svg {
            flex-shrink: 0;
            color: var(--c-success);
            margin-top: 2px;
        }

        .status-message p {
            margin: 0;
            font-size: 0.875rem;
            color: var(--c-text);
            line-height: 1.5;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.15s ease;
            width: 100%;
        }

        .btn-primary {
            background: var(--c-accent);
            color: #fff;
            box-shadow: 0 1px 3px 0 rgba(99, 102, 241, 0.1), 0 1px 2px 0 rgba(99, 102, 241, 0.06);
        }

        .btn-primary:hover {
            background: #6a59e8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124,106,247,0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--c-text-light);
            border: 1px solid var(--c-border);
        }

        .btn-secondary:hover {
            background: var(--c-bg);
            color: var(--c-text);
            border-color: var(--c-accent);
        }

        .footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--c-border);
        }

        .footer-link {
            font-size: 0.875rem;
            color: var(--c-text-light);
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-link:hover {
            color: var(--c-accent);
        }

        @media (max-width: 480px) {
            .verify-container {
                padding: 32px 24px;
                margin: 20px;
            }
            .profile-avatar {
                width: 64px;
                height: 64px;
            }
            .profile-avatar svg {
                width: 24px;
                height: 24px;
            }
            .brand-name { font-size: 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <!-- Profile Section -->
        <div class="profile-section">
            <div class="profile-avatar">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="profile-name">{{ Auth::user()->name ?? 'User' }}</div>
            <div class="profile-email">{{ Auth::user()->email ?? 'your.email@example.com' }}</div>
        </div>

        <!-- Brand Section -->
        <div class="brand-section">
            <div class="brand-name">TaskFlow</div>
            <div class="brand-tagline">Professional Task Management</div>
        </div>

        <!-- Message -->
        <div class="message">
            Please verify your email address to complete your account setup and start managing your tasks efficiently.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="status-message">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <p>A new verification link has been sent to your email address.</p>
            </div>
        @endif

        <!-- Actions -->
        <div class="actions">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            <a class="footer-link" href="{{ route('login') }}">
                ← Return to Sign In
            </a>
        </div>
    </div>
</body>
</html>
