<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskFlow — {{ __('Reset Password') }}</title>

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
            --c-muted: #8888a0;
            --c-success: #22c55e;
            --c-danger: #ef4444;
        }

        /* Light theme */
        [data-theme="light"] {
            --c-bg: #ffffff;
            --c-surface: #f8f8fc;
            --c-border: #e5e5ed;
            --c-accent: #7c6af7;
            --c-accent-light: #6a59e8;
            --c-text: #1a1a2e;
            --c-muted: #7a7a8c;
            --c-success: #16a34a;
            --c-danger: #dc2626;
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

        .container {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--c-accent-light);
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .logo span { color: var(--c-text); }

        .subtitle {
            color: var(--c-muted);
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--c-muted);
        }

        .form-input {
            width: 100%;
            background: var(--c-bg);
            border: 1px solid var(--c-border);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--c-text);
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.15s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(124,106,247,0.15);
        }

        .form-input.error { border-color: var(--c-danger); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.15s;
            width: 100%;
        }

        .btn-primary {
            background: var(--c-accent);
            color: #fff;
        }

        .btn-primary:hover {
            background: #6a59e8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124,106,247,0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--c-muted);
            border: 1px solid var(--c-border);
            width: auto;
            flex: 1;
        }

        .btn-secondary:hover {
            border-color: var(--c-accent);
            color: var(--c-text);
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .button-group .btn {
            width: 100%;
        }

        .error-msg {
            color: var(--c-danger);
            font-size: 0.8rem;
            margin-top: 6px;
        }

        .success-msg {
            color: var(--c-success);
            font-size: 0.85rem;
            padding: 12px 16px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .links-section {
            display: flex;
            justify-content: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--c-border);
        }

        .link {
            font-size: 0.85rem;
            color: var(--c-muted);
            text-decoration: none;
            transition: color 0.15s;
        }

        .link:hover {
            color: var(--c-accent-light);
        }

        @media (max-width: 480px) {
            .container {
                padding: 24px;
                margin: 20px;
            }
            .logo { font-size: 2rem; }
            .button-group {
                flex-direction: column;
            }
        }
    </style>

    <script>
        // Initialize theme on page load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <div class="logo">Task<span>Flow</span></div>
            <p class="subtitle">Forgot your password? Let us help you reset it.</p>
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="success-msg">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input
                    id="email"
                    class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="Enter your email address"
                >
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 5 12 12 19"/>
                    </svg>
                    Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 12a8 8 0 018-8c1.045 0 2.052.126 3.022.373"/>
                        <path d="M16 4.826A8 8 0 0012 20c-1.045 0-2.052-.126-3.022-.373"/>
                    </svg>
                    Send Reset Link
                </button>
            </div>
        </form>

        <div class="links-section">
            <a class="link" href="{{ route('register') }}">
                Create an account
            </a>
        </div>
    </div>
</body>
</html>
