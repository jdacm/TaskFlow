<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TaskFlow') }} — @yield('title', 'Dashboard')</title>

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
            --c-warning: #f59e0b;
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
            --c-warning: #d97706;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--c-bg);
            color: var(--c-text);
            min-height: 100vh;
        }

        h1, h2, h3, .font-display {
            font-family: 'Syne', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: var(--c-surface);
            border-right: 1px solid var(--c-border);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
        }

        .sidebar-logo {
            padding: 24px 20px 16px;
            border-bottom: 1px solid var(--c-border);
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--c-accent-light);
        }

        .sidebar-logo span { color: var(--c-text); }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: var(--c-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.15s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(124,106,247,0.08);
            color: var(--c-text);
            border-left-color: var(--c-accent);
        }

        .nav-link.active {
            background: rgba(124,106,247,0.12);
            color: var(--c-accent-light);
            border-left-color: var(--c-accent);
        }

        .nav-section {
            padding: 16px 20px 6px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--c-muted);
        }

        /* Main content */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }

        .top-bar {
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .page-content {
            padding: 32px;
        }

        /* Cards */
        .card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 12px;
            padding: 20px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.15s ease;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary {
            background: var(--c-accent);
            color: #fff;
        }
        .btn-primary:hover { background: #6a59e8; transform: translateY(-1px); }

        .btn-secondary {
            background: transparent;
            color: var(--c-muted);
            border: 1px solid var(--c-border);
        }
        .btn-secondary:hover { border-color: var(--c-accent); color: var(--c-text); }

        .btn-danger {
            background: transparent;
            color: var(--c-danger);
            border: 1px solid #ef444440;
        }
        .btn-danger:hover { background: #ef44440f; }

        .btn-success {
            background: transparent;
            color: var(--c-success);
            border: 1px solid #22c55e40;
        }
        .btn-success:hover { background: #22c55e0f; }

        .btn-sm { padding: 5px 12px; font-size: 0.8rem; }

        /* Form inputs */
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.8rem;
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
            padding: 10px 14px;
            color: var(--c-text);
            font-size: 0.9rem;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.15s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(124,106,247,0.15);
        }

        .form-input.error { border-color: var(--c-danger); }

        select.form-input option { background: var(--c-surface); }

        .error-msg {
            color: var(--c-danger);
            font-size: 0.8rem;
            margin-top: 4px;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .badge-pending     { background: rgba(245,158,11,0.15); color: #f59e0b; }
        .badge-in-progress { background: rgba(99,102,241,0.15); color: #818cf8; }
        .badge-completed   { background: rgba(34,197,94,0.15);  color: #22c55e; }
        .badge-overdue     { background: rgba(239,68,68,0.15);  color: #ef4444; }

        /* Stat cards */
        .stat-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 12px;
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
        }

        .stat-card.total::before   { background: var(--c-accent); }
        .stat-card.pending::before { background: var(--c-warning); }
        .stat-card.progress::before{ background: #818cf8; }
        .stat-card.done::before    { background: var(--c-success); }
        .stat-card.overdue::before { background: var(--c-danger); }

        .stat-number {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--c-muted);
            margin-top: 4px;
            font-weight: 500;
        }

        /* Task rows */
        .task-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--c-border);
        }

        .task-row:last-child { border-bottom: none; }

        /* Flash messages */
        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .flash-success {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            color: #4ade80;
        }

        .flash-error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
        }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            padding: 10px 16px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--c-muted);
            border-bottom: 1px solid var(--c-border);
        }
        td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(42,42,53,0.6);
            vertical-align: middle;
            font-size: 0.875rem;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(124,106,247,0.04); }

        /* Mobile nav toggle */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--c-text);
            padding: 4px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-menu-btn { display: flex; }
            .page-content { padding: 16px; }
            .top-bar { padding: 12px 16px; }
        }

        /* Theme toggle button */
        .theme-toggle-btn {
            background: none;
            border: 1px solid var(--c-border);
            border-radius: 8px;
            padding: 6px 10px;
            cursor: pointer;
            color: var(--c-text);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .theme-toggle-btn:hover {
            background: rgba(124,106,247,0.1);
            border-color: var(--c-accent);
        }

        /* Additional Themes */
        [data-theme="opera"] {
            --c-bg: #1a1a1a;
            --c-surface: #2a2a2a;
            --c-border: #404040;
            --c-accent: #ff1b5a;
            --c-accent-light: #ff6b8a;
            --c-text: #ffffff;
            --c-muted: #cccccc;
            --c-success: #00ff88;
            --c-danger: #ff4757;
            --c-warning: #ffa500;
        }

        [data-theme="forest"] {
            --c-bg: #0a1f0a;
            --c-surface: #1a3a1a;
            --c-border: #2a5a2a;
            --c-accent: #4ade80;
            --c-accent-light: #6ee7a0;
            --c-text: #e8f5e8;
            --c-muted: #a8d5a8;
            --c-success: #22c55e;
            --c-danger: #ef4444;
            --c-warning: #f59e0b;
        }

        [data-theme="ocean"] {
            --c-bg: #0a1929;
            --c-surface: #1a365d;
            --c-border: #2a4a7a;
            --c-accent: #06b6d4;
            --c-accent-light: #22d3ee;
            --c-text: #e0f2fe;
            --c-muted: #a8d5f0;
            --c-success: #10b981;
            --c-danger: #ef4444;
            --c-warning: #f59e0b;
        }

        [data-theme="sunset"] {
            --c-bg: #2d1b69;
            --c-surface: #4c2a85;
            --c-border: #6b46c1;
            --c-accent: #f97316;
            --c-accent-light: #fb923c;
            --c-text: #fef3c7;
            --c-muted: #d4b5f0;
            --c-success: #22c55e;
            --c-danger: #ef4444;
            --c-warning: #eab308;
        }

        /* Chatbot Styles */
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            height: 500px;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .chatbot-container.open {
            transform: translateY(0);
            opacity: 1;
        }

        .chatbot-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--c-accent) 0%, var(--c-accent-light) 100%);
            border-radius: 16px 16px 0 0;
            color: white;
        }

        .chatbot-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .message {
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .message.bot {
            background: var(--c-accent);
            color: white;
            align-self: flex-start;
        }

        .message.user {
            background: var(--c-bg);
            color: var(--c-text);
            border: 1px solid var(--c-border);
            align-self: flex-end;
        }

        .chatbot-input-area {
            padding: 16px 20px;
            border-top: 1px solid var(--c-border);
            display: flex;
            gap: 8px;
        }

        .chatbot-input {
            flex: 1;
            background: var(--c-bg);
            border: 1px solid var(--c-border);
            border-radius: 8px;
            padding: 8px 12px;
            color: var(--c-text);
            font-size: 0.875rem;
            outline: none;
        }

        .chatbot-input:focus {
            border-color: var(--c-accent);
        }

        .chatbot-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: var(--c-accent);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .chatbot-toggle:hover {
            transform: scale(1.05);
            background: var(--c-accent-light);
        }
    </style>

    <script>
        // Initialize theme on page load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.getElementById('themeSelector').value = savedTheme;
        })();

        // Change theme function
        function changeTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            updateThemeIcon();
        }

        // Toggle theme function (legacy support)
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            document.getElementById('themeSelector').value = newTheme;
            updateThemeIcon();
        }

        // Update button icon based on current theme
        function updateThemeIcon() {
            const btn = document.getElementById('themeToggleBtn');
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';

            if (currentTheme === 'dark') {
                btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';
                btn.title = 'Switch to Light Mode';
            } else {
                btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
                btn.title = 'Switch to Dark Mode';
            }
        }

        // Set initial icon
        document.addEventListener('DOMContentLoaded', updateThemeIcon);

        // Chatbot functionality
        let chatbotMessages = [];
        const motivationalMessages = [
            "Hey there! Ready to tackle some tasks today? 💪",
            "I see you have some tasks waiting. Let's get them done!",
            "Remember: Every completed task brings you closer to your goals! 🎯",
            "You've got this! One task at a time. 🚀",
            "Procrastination is the thief of time. Let's beat it together! ⚡",
            "Small steps lead to big achievements. What's one task you can complete now?",
            "Your future self will thank you for getting things done today! 🙏",
            "Action creates motivation. Let's start with something small! 🌟",
            "Every expert was once a beginner. Keep pushing forward! 📈",
            "The best time to start was yesterday. The second best time is now! ⏰"
        ];

        function initChatbot() {
            const container = document.querySelector('.chatbot-container');
            const toggle = document.querySelector('.chatbot-toggle');
            const input = document.querySelector('.chatbot-input');
            const messages = document.querySelector('.chatbot-messages');

            if (!container || !toggle || !input || !messages) {
                console.error('Chatbot elements not found');
                return;
            }

            toggle.addEventListener('click', () => {
                container.classList.add('open');
                toggle.style.display = 'none';
            });

            document.addEventListener('click', (e) => {
                if (!container.contains(e.target) && !toggle.contains(e.target)) {
                    container.classList.remove('open');
                    toggle.style.display = 'flex';
                }
            });

            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendMessage(input.value, input);
                    input.value = '';
                }
            });

            // Add initial greeting
            setTimeout(() => {
                addMessage(motivationalMessages[Math.floor(Math.random() * motivationalMessages.length)], 'bot');
            }, 1000);
        }

        function addMessage(text, sender) {
            const messages = document.querySelector('.chatbot-messages');
            if (!messages) {
                console.error('Messages container not found');
                return;
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;
            messageDiv.textContent = text;
            messages.appendChild(messageDiv);
            messages.scrollTop = messages.scrollHeight;
        }

        function sendMessage(text, inputElement) {
            if (!text.trim()) return;

            addMessage(text, 'user');

            // Simple bot responses
            setTimeout(() => {
                const responses = [
                    "That's a great goal! Let's break it down into smaller steps. 📝",
                    "I believe in you! You've got the skills to make this happen. 🌟",
                    "Accountability is key! Set a timer and get started. ⏱️",
                    "Remember why you started. Your motivation is within you! 🔥",
                    "Progress over perfection. Take that first step now! 👣",
                    "You're capable of amazing things. Start small, dream big! 💫",
                    "Every journey begins with a single step. What's yours? 🚶",
                    "Success is built on consistent action. Let's build yours! 🏗️"
                ];

                const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                addMessage(randomResponse, 'bot');
            }, 500 + Math.random() * 1000);
        }

        // Initialize chatbot when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                initChatbot();
            }, 100); // Small delay to ensure elements are ready
        });
    </script>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        Task<span>Flow</span>
    </div>

    <div style="flex:1; overflow-y:auto; padding: 12px 0;">
        <div class="nav-section">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            My Tasks
        </a>
        <a href="{{ route('tasks.create') }}" class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            New Task
        </a>

        <div class="nav-section">Manage</div>
        <a href="{{ route('subjects.index') }}" class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            Subjects
        </a>
        <a href="{{ route('priorities.index') }}" class="nav-link {{ request()->routeIs('priorities.*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            Priorities
        </a>

        <div class="nav-section">Account</div>
        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profile
        </a>
    </div>

    <!-- User section -->
    <div style="border-top: 1px solid var(--c-border); padding: 16px 20px;">
        <div style="font-size:0.8rem; color:var(--c-muted); margin-bottom:4px;">Signed in as</div>
        <div style="font-size:0.875rem; font-weight:600; color:var(--c-text); margin-bottom:12px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm" style="width:100%; justify-content:center;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </div>
</nav>

<!-- Main -->
<div class="main-content">
    <div class="top-bar">
        <div style="display:flex; align-items:center; gap:12px;">
            <button class="mobile-menu-btn" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <h1 class="font-display" style="font-size:1.1rem; font-weight:700; margin:0;">@yield('title', 'Dashboard')</h1>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <select id="themeSelector" class="form-input" style="width:auto; padding:6px 10px; font-size:0.8rem;" onchange="changeTheme(this.value)">
                <option value="dark">Dark</option>
                <option value="light">Light</option>
                <option value="opera">Opera</option>
                <option value="forest">Forest</option>
                <option value="ocean">Ocean</option>
                <option value="sunset">Sunset</option>
            </select>
            <button id="themeToggleBtn" class="theme-toggle-btn" onclick="toggleTheme()"></button>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Task
            </a>
        </div>
    </div>

    <div class="page-content">
        @include('components.flash-message')
        @yield('content')
    </div>
</div>

<!-- Chatbot -->
<div class="chatbot-container">
    <div class="chatbot-header">
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="font-size:1.2rem;">🤖</span>
            <span style="font-weight:600;">Task Buddy</span>
        </div>
        <button onclick="document.querySelector('.chatbot-container').classList.remove('open')" style="background:none; border:none; color:white; cursor:pointer; font-size:1.2rem;">×</button>
    </div>
    <div class="chatbot-messages"></div>
    <div class="chatbot-input-area">
        <input type="text" class="chatbot-input" placeholder="Tell me about your goals...">
    </div>
</div>

<button class="chatbot-toggle" title="Chat with Task Buddy">💬</button>

</body>
</html>
