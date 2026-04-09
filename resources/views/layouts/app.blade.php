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
    <script>
        // Apply persisted theme as early as possible to avoid flashbacks to dark.
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        })();
    </script>
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
            transition: margin-left 0.25s ease;
        }

        .top-bar {
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .page-content {
            padding: 32px;
            max-width: 1320px;
            margin: 0 auto;
            width: min(100%, 1320px);
        }

        /* Cards */
        .card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 12px;
            padding: 20px;
            width: 100%;
            overflow: hidden;
        }

        .page-content .profile-grid {
            display: grid;
            grid-template-columns: minmax(0, 320px) minmax(0, 1fr);
            gap: 24px;
        }

        .dashboard-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .dashboard-two-col-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .dashboard-two-col-grid > .card {
            min-width: 0;
        }

        .task-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--c-border);
            flex-wrap: wrap;
        }

        .task-row > * {
            min-width: 0;
        }

        .theme-selector {
            width: auto;
        }

        .theme-dropdown {
            min-width: 180px;
        }

        .page-content .profile-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .page-content .profile-header .profile-avatar {
            min-width: 72px;
            min-height: 72px;
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--c-accent);
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .page-content .profile-summary {
            display: grid;
            gap: 16px;
        }

        .page-content .profile-block {
            padding: 24px;
        }

        .page-content .profile-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
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

        @media (max-width: 1024px) {
            .page-content {
                padding: 24px;
            }

            .page-content .profile-grid {
                grid-template-columns: 1fr;
            }

            .page-content .profile-block {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                width: 100%;
                max-width: 320px;
            }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-menu-btn { display: flex; }
            .page-content { padding: 16px; }
            .top-bar { padding: 12px 16px; }
            .top-bar { justify-content: space-between; }
            .motivational-quote { display: none; }
            .page-content .profile-grid { grid-template-columns: 1fr; }
            .page-content .profile-block { padding: 18px; }
            .theme-selector {
                width: 100%;
            }
            .theme-btn {
                width: 100%;
                justify-content: space-between;
            }
            .theme-dropdown {
                left: 0;
                right: auto;
                min-width: 100%;
            }
            .nav-link {
                padding: 12px 18px;
                font-size: 0.95rem;
            }
            .sidebar-logo {
                padding: 20px 18px 14px;
            }
            .main-content {
                min-height: auto;
            }
            table {
                display: block;
                width: 100%;
                overflow-x: auto;
            }
            th, td {
                white-space: nowrap;
            }
        }

        /* Modern Theme Selector */
        .theme-selector {
            position: relative;
            display: inline-block;
        }

        .theme-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 8px 12px;
            cursor: pointer;
            color: var(--c-text);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 120px;
            justify-content: space-between;
            backdrop-filter: blur(8px);
            position: relative;
        }

        /* Light theme adjustments */
        [data-theme="light"] .theme-btn {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--c-text);
        }

        .theme-btn:hover {
            background: rgba(124,106,247,0.15);
            border-color: var(--c-accent);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* Light theme hover */
        [data-theme="light"] .theme-btn:hover {
            background: rgba(124,106,247,0.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .theme-btn svg {
            transition: transform 0.2s ease;
            opacity: 0.8;
        }

        .theme-btn.open svg {
            transform: rotate(180deg);
            opacity: 1;
        }

        .theme-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(15, 15, 19, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            min-width: 160px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
            z-index: 1000;
            margin-top: 8px;
            backdrop-filter: blur(12px);
        }

        /* Light theme dropdown */
        [data-theme="light"] .theme-dropdown {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }

        .theme-dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .theme-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            cursor: pointer;
            color: #e8e8f0;
            transition: all 0.15s ease;
            border-radius: 8px;
            margin: 4px 8px;
        }

        /* Light theme option text */
        [data-theme="light"] .theme-option {
            color: #1a1a2e;
        }

        .theme-option:hover {
            background: rgba(124,106,247,0.15);
        }

        /* Light theme option hover */
        [data-theme="light"] .theme-option:hover {
            background: rgba(124,106,247,0.1);
        }

        .theme-option.active {
            background: var(--c-accent);
            color: white;
        }

        .theme-option svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            stroke: #e8e8f0;
        }

        /* Light theme icon colors */
        [data-theme="light"] .theme-option svg {
            stroke: #1a1a2e;
        }

        .theme-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 8px 0;
        }

        /* Light theme divider */
        [data-theme="light"] .theme-divider {
            background: rgba(0, 0, 0, 0.1);
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
    </style>

    <script>
        // Initialize theme on page load after the DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeDisplay();
        });

        // Toggle theme dropdown
        function toggleThemeDropdown() {
            const dropdown = document.getElementById('themeDropdown');
            const btn = document.getElementById('themeBtn');
            const isOpen = dropdown.classList.contains('open');

            if (isOpen) {
                dropdown.classList.remove('open');
                btn.classList.remove('open');
            } else {
                dropdown.classList.add('open');
                btn.classList.add('open');
            }
        }

        // Close dropdown and mobile sidebar when clicking outside
        document.addEventListener('click', function(e) {
            const themeSelector = document.querySelector('.theme-selector');
            const dropdown = document.getElementById('themeDropdown');
            const btn = document.getElementById('themeBtn');
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');

            if (!themeSelector.contains(e.target)) {
                dropdown.classList.remove('open');
                btn.classList.remove('open');
            }

            if (sidebar && sidebar.classList.contains('open')) {
                const clickedInsideSidebar = sidebar.contains(e.target);
                const clickedMenuButton = mobileMenuBtn && mobileMenuBtn.contains(e.target);

                if (!clickedInsideSidebar && !clickedMenuButton) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Select theme function
        function selectTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            updateThemeDisplay();

            // Close dropdown
            const dropdown = document.getElementById('themeDropdown');
            const btn = document.getElementById('themeBtn');
            dropdown.classList.remove('open');
            btn.classList.remove('open');
        }

        // Update theme display
        function updateThemeDisplay() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const textElement = document.getElementById('currentThemeText');

            // Update button text
            const themeNames = {
                'dark': 'Dark',
                'light': 'Light',
                'opera': 'Opera',
                'forest': 'Forest',
                'ocean': 'Ocean',
                'sunset': 'Sunset'
            };
            if (textElement) {
                textElement.textContent = themeNames[currentTheme] || 'Dark';
            }

            // Update active state in dropdown
            document.querySelectorAll('.theme-option').forEach(option => {
                option.classList.remove('active');
                if (option.getAttribute('data-theme') === currentTheme) {
                    option.classList.add('active');
                }
            });
        }
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

        {{-- Daily Motivational Quote --}}
        <div class="motivational-quote" style="flex:1; text-align:center; max-width:400px; margin:0 20px;">
            <p style="margin:0; font-size:0.9rem; color:var(--c-muted); font-style:italic; line-height:1.4;">
                @php
                    $quotes = [
                        "The only way to do great work is to love what you do. – Steve Jobs",
                        "Believe you can and you're halfway there. – Theodore Roosevelt",
                        "The future belongs to those who believe in the beauty of their dreams. – Eleanor Roosevelt",
                        "You miss 100% of the shots you don't take. – Wayne Gretzky",
                        "The best way to predict the future is to create it. – Peter Drucker",
                        "Don't watch the clock; do what it does. Keep going. – Sam Levenson",
                        "The only limit to our realization of tomorrow will be our doubts of today. – Franklin D. Roosevelt",
                        "Success is not final, failure is not fatal: It is the courage to continue that counts. – Winston Churchill",
                        "Your time is limited, so don't waste it living someone else's life. – Steve Jobs",
                        "The way to get started is to quit talking and begin doing. – Walt Disney",
                        "Keep your face always toward the sunshine—and shadows will fall behind you. – Walt Whitman",
                        "The secret of getting ahead is getting started. – Mark Twain",
                        "What lies behind us and what lies before us are tiny matters compared to what lies within us. – Ralph Waldo Emerson",
                        "You can't build a reputation on what you are going to do. – Henry Ford",
                        "The only person you are destined to become is the person you decide to be. – Ralph Waldo Emerson"
                    ];
                    $dailyQuote = $quotes[date('z') % count($quotes)]; // Use day of year for consistent daily quote
                @endphp
                {{ $dailyQuote }}
            </p>
        </div>

        <div style="display:flex; align-items:center; gap:8px;">
            <div class="theme-selector">
                <button id="themeBtn" class="theme-btn" onclick="toggleThemeDropdown()">
                    <span id="currentThemeText">Dark</span>
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </button>
                <div id="themeDropdown" class="theme-dropdown">
                    <div class="theme-option" data-theme="dark" onclick="selectTheme('dark')">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                        Dark
                    </div>
                    <div class="theme-option" data-theme="light" onclick="selectTheme('light')">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        Light
                    </div>
                    <div class="theme-divider"></div>
                    <div class="theme-option" data-theme="opera" onclick="selectTheme('opera')">
                        <div style="width:16px; height:16px; background:linear-gradient(45deg, #ff1b5a, #ff6b8a); border-radius:50%;"></div>
                        Opera
                    </div>
                    <div class="theme-option" data-theme="forest" onclick="selectTheme('forest')">
                        <div style="width:16px; height:16px; background:linear-gradient(45deg, #22c55e, #16a34a); border-radius:50%;"></div>
                        Forest
                    </div>
                    <div class="theme-option" data-theme="ocean" onclick="selectTheme('ocean')">
                        <div style="width:16px; height:16px; background:linear-gradient(45deg, #3b82f6, #1d4ed8); border-radius:50%;"></div>
                        Ocean
                    </div>
                    <div class="theme-option" data-theme="sunset" onclick="selectTheme('sunset')">
                        <div style="width:16px; height:16px; background:linear-gradient(45deg, #f59e0b, #d97706); border-radius:50%;"></div>
                        Sunset
                    </div>
                </div>
            </div>
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

</body>
</html>
