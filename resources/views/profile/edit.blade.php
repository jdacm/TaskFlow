{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Profile')

@section('content')

<div class="card" style="max-width:600px; margin:0 auto;">
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
        <div style="width:48px; height:48px; border-radius:50%; background:var(--c-accent); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:1.2rem;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 style="font-size:1.5rem; font-weight:700; margin:0; color:var(--c-text);">{{ Auth::user()->name }}</h1>
            <p style="color:var(--c-muted); margin:4px 0 0 0; font-size:0.875rem;">{{ Auth::user()->email }}</p>
        </div>
    </div>

    {{-- Under Construction Notice --}}
    <div style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); border-radius: 12px; padding: 20px; margin-bottom: 24px; text-align: center;">
        <div style="font-size: 2rem; margin-bottom: 8px;">🚧</div>
        <h3 style="color: #f59e0b; font-weight: 600; margin: 0 0 8px 0;">Profile Page Under Construction</h3>
        <p style="color: var(--c-muted); margin: 0; font-size: 0.875rem;">
            This profile page is currently incomplete. Basic user information is displayed, but additional features like profile editing, password changes, and account management are not yet implemented.
        </p>
    </div>

    {{-- Basic Info Section --}}
    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin: 0 0 16px 0; color: var(--c-text);">Account Information</h2>
        <div style="display: grid; gap: 12px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--c-bg); border: 1px solid var(--c-border); border-radius: 8px;">
                <span style="color: var(--c-muted); font-size: 0.875rem;">Email Address</span>
                <span style="color: var(--c-text); font-weight: 500;">{{ Auth::user()->email }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--c-bg); border: 1px solid var(--c-border); border-radius: 8px;">
                <span style="color: var(--c-muted); font-size: 0.875rem;">Member Since</span>
                <span style="color: var(--c-text); font-weight: 500;">{{ Auth::user()->created_at->format('M d, Y') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--c-bg); border: 1px solid var(--c-border); border-radius: 8px;">
                <span style="color: var(--c-muted); font-size: 0.875rem;">Account Status</span>
                <span style="color: var(--c-success); font-weight: 500;">Active</span>
            </div>
        </div>
    </div>

    {{-- Coming Soon Features --}}
    <div style="background: rgba(124,106,247,0.05); border: 1px solid rgba(124,106,247,0.2); border-radius: 12px; padding: 20px;">
        <h3 style="color: var(--c-accent); font-weight: 600; margin: 0 0 12px 0; font-size: 1rem;">Coming Soon</h3>
        <ul style="color: var(--c-muted); margin: 0; padding-left: 20px; font-size: 0.875rem; line-height: 1.5;">
            <li>Profile picture upload</li>
            <li>Password change functionality</li>
            <li>Account preferences and settings</li>
            <li>Two-factor authentication</li>
            <li>Account deletion options</li>
        </ul>
    </div>
</div>

@endsection
