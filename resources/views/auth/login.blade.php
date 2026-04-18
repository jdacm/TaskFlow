<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskFlow — {{ __('Log in') }}</title>

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

        .login-container {
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

        .password-input-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--c-muted);
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: color 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: var(--c-text);
            background: rgba(255, 255, 255, 0.05);
        }

        .eye-icon {
            width: 20px;
            height: 20px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            accent-color: var(--c-accent);
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: var(--c-muted);
            cursor: pointer;
        }

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

        .links-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        @media (max-width: 480px) {
            .login-container {
                padding: 24px;
                margin: 20px;
            }
            .logo { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo">Task<span>Flow</span></div>
            <p class="subtitle">Welcome back! Please sign in to continue.</p>
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

        <form method="POST" action="{{ route('login') }}">
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
                    autocomplete="username"
                    placeholder="Enter your email"
                >
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="password-input-container">
                    <input
                        id="password"
                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                    <button type="button" class="password-toggle" data-target="password">
                        <svg class="eye-icon eye-show" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="eye-icon eye-hide" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="checkbox-group">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="checkbox-input"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label class="checkbox-label" for="remember_me">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Sign In
            </button>
        </form>

        <div class="links-section">
            <div>
                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div>
                @if (Route::has('register'))
                    <a class="link" href="{{ route('register') }}">
                        Create account →
                    </a>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.password-toggle');

            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const eyeShow = this.querySelector('.eye-show');
                    const eyeHide = this.querySelector('.eye-hide');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeShow.style.display = 'none';
                        eyeHide.style.display = 'block';
                    } else {
                        passwordInput.type = 'password';
                        eyeShow.style.display = 'block';
                        eyeHide.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
