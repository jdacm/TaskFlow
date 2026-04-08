{{-- resources/views/priorities/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Priorities')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:1.1rem; font-weight:700; margin:0;">Task Priorities</h2>
    <a href="{{ route('priorities.create') }}" class="btn btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Priority
    </a>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Level</th>
                <th>Color</th>
                <th style="text-align:right;">Tasks</th>
                <th style="width:80px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($priorities as $priority)
                <tr>
                    <td style="font-weight:600;">{{ $priority->name }}</td>
                    <td>{{ $priority->level }}</td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:8px;">
                            <span style="width:16px;height:16px;border-radius:6px;background:{{ $priority->color }};"></span>
                            <code style="font-size:0.8rem; color:var(--c-muted);">{{ $priority->color }}</code>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <span style="font-weight:600;">{{ $priority->tasks_count }}</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('priorities.destroy', $priority) }}" onsubmit="return confirm('Delete this priority?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:48px 16px; color:var(--c-muted);">
                        <div style="font-size:2rem; margin-bottom:8px;">⚡</div>
                        <div style="font-weight:600; margin-bottom:8px;">No priorities yet</div>
                        <a href="{{ route('priorities.create') }}" style="color:var(--c-accent-light);">Create your first priority</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
