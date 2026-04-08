<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskFlow — {{ __('Register') }}</title>

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

        .register-container {
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

        .error-msg {
            color: var(--c-danger);
            font-size: 0.8rem;
            margin-top: 6px;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 24px;
                margin: 20px;
            }
            .logo { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo">Task<span>Flow</span></div>
            <p class="subtitle">Create your account to get started.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input
                    id="name"
                    class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name"
                >
                @error('name')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

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
                <input
                    id="password"
                    class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create a password"
                >
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    class="form-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                >
                @error('password_confirmation')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Create Account
            </button>
        </form>

        <div class="links-section">
            <a class="link" href="{{ route('login') }}">
                ← Already have an account?
            </a>
        </div>
    </div>
</body>
</html>
