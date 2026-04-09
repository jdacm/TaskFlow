{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Profile')

@section('content')

<div class="card" style="max-width:720px; margin:0 auto;">
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px;">
        <div style="display:flex; align-items:center; gap:14px; min-width:0;">
            <div style="width:48px; height:48px; border-radius:50%; background:var(--c-accent); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:1.2rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <p style="margin:0 0 6px 0; color:var(--c-muted); font-size:0.8rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase;">Profile</p>
                <h1 style="margin:0; font-size:1.8rem; font-weight:800; line-height:1.1; color:var(--c-text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $user->name }}</h1>
                <p style="margin:8px 0 0 0; color:var(--c-muted); font-size:0.95rem;">{{ $user->email }}</p>
            </div>
        </div>

        @php
            $profileEditOpen = $errors->any() || session('status');
        @endphp

        <div style="display:flex; flex-wrap:wrap; gap:10px;">
            <button id="toggleProfileEdit" type="button" class="btn btn-primary btn-sm"
                onclick="const panel = document.getElementById('profile-edit-panel'); const visible = panel.style.display !== 'none'; panel.style.display = visible ? 'none' : 'grid'; this.textContent = visible ? 'Edit Profile' : 'Hide Edit';">
                {{ $profileEditOpen ? 'Hide Edit' : 'Edit Profile' }}
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Back to Dashboard</a>
        </div>
    </div>

    <section class="card" style="margin-bottom:24px;">
        <div style="display:grid; gap:14px;">
            <div style="display:flex; justify-content:space-between; gap:16px; padding:16px; background:var(--c-bg); border:1px solid var(--c-border); border-radius:12px;">
                <span style="color:var(--c-muted); font-size:0.9rem;">Member since</span>
                <span style="color:var(--c-text); font-weight:600;">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; gap:16px; padding:16px; background:var(--c-bg); border:1px solid var(--c-border); border-radius:12px;">
                <span style="color:var(--c-muted); font-size:0.9rem;">Email verified</span>
                <span style="color:{{ $user->hasVerifiedEmail() ? 'var(--c-success)' : 'var(--c-warning)' }}; font-weight:600;">{{ $user->hasVerifiedEmail() ? 'Verified' : 'Pending' }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; gap:16px; padding:16px; background:var(--c-bg); border:1px solid var(--c-border); border-radius:12px;">
                <span style="color:var(--c-muted); font-size:0.9rem;">Account status</span>
                <span style="color:var(--c-success); font-weight:600;">Active</span>
            </div>
        </div>
    </section>

    <div id="profile-edit-panel" style="display: {{ $profileEditOpen ? 'grid' : 'none' }}; gap:24px;">
        <section class="card">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="card">
            @include('profile.partials.update-password-form')
        </section>

        <section class="card">
            @include('profile.partials.delete-user-form')
        </section>
    </div>
</div>

@endsection
