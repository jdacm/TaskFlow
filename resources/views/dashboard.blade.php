{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:16px; margin-bottom:32px;">
    <div class="stat-card total">
        <div class="stat-number" style="color:var(--c-accent-light);">{{ $stats['total'] }}</div>
        <div class="stat-label">Total Tasks</div>
    </div>
    <div class="stat-card pending">
        <div class="stat-number" style="color:var(--c-warning);">{{ $stats['pending'] }}</div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card progress">
        <div class="stat-number" style="color:#818cf8;">{{ $stats['in_progress'] }}</div>
        <div class="stat-label">In Progress</div>
    </div>
    <div class="stat-card done">
        <div class="stat-number" style="color:var(--c-success);">{{ $stats['completed'] }}</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card overdue">
        <div class="stat-number" style="color:var(--c-danger);">{{ $stats['overdue'] }}</div>
        <div class="stat-label">Overdue</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

    {{-- Upcoming Tasks --}}
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="font-size:1rem; font-weight:700; margin:0;">Upcoming Tasks</h2>
            <a href="{{ route('tasks.index') }}" style="font-size:0.8rem; color:var(--c-accent-light); text-decoration:none;">View all →</a>
        </div>

        @forelse($upcomingTasks as $task)
            <div class="task-row">
                {{-- Toggle complete button --}}
                <form method="POST" action="{{ route('tasks.toggle-complete', $task) }}">
                    @csrf @method('PATCH')
                    <button type="submit" style="width:18px;height:18px;border-radius:50%;border:2px solid var(--c-border);background:none;cursor:pointer;flex-shrink:0;" title="Mark complete"></button>
                </form>

                <div style="flex:1; min-width:0;">
                    <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-text); text-decoration:none; font-weight:500; font-size:0.875rem; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $task->title }}
                    </a>
                    <div style="font-size:0.75rem; color:var(--c-muted); margin-top:2px;">
                        Due {{ $task->due_date->format('M d, Y') }}
                        @if($task->subject)
                            · <span style="color:{{ $task->subject->color }};">{{ $task->subject->name }}</span>
                        @endif
                    </div>
                </div>

                @if($task->priority)
                    <span class="badge" style="background:{{ $task->priority->color }}22; color:{{ $task->priority->color }}; white-space:nowrap;">
                        {{ $task->priority->name }}
                    </span>
                @endif
            </div>
        @empty
            <p style="color:var(--c-muted); font-size:0.875rem; text-align:center; padding:24px 0;">
                🎉 No upcoming tasks! You're all caught up.
            </p>
        @endforelse
    </div>

    {{-- Overdue / Recent --}}
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="font-size:1rem; font-weight:700; margin:0;">Needs Attention</h2>
            <a href="{{ route('tasks.index', ['status' => 'pending']) }}" style="font-size:0.8rem; color:var(--c-accent-light); text-decoration:none;">View all →</a>
        </div>

        @forelse($recentTasks as $task)
            <div class="task-row">
                <div style="flex-shrink:0;">
                    @if($task->isOverdue())
                        <div style="width:8px;height:8px;border-radius:50%;background:var(--c-danger);"></div>
                    @else
                        <div style="width:8px;height:8px;border-radius:50%;background:var(--c-warning);"></div>
                    @endif
                </div>

                <div style="flex:1; min-width:0;">
                    <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-text); text-decoration:none; font-weight:500; font-size:0.875rem; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $task->title }}
                    </a>
                    <div style="font-size:0.75rem; margin-top:2px; {{ $task->isOverdue() ? 'color:var(--c-danger)' : 'color:var(--c-muted)' }};">
                        @if($task->isOverdue())
                            Overdue · {{ $task->due_date->format('M d') }}
                        @else
                            Due {{ $task->due_date->format('M d, Y') }}
                        @endif
                    </div>
                </div>

                <span class="badge badge-{{ str_replace('_','-',$task->status) }}">{{ $task->statusLabel() }}</span>
            </div>
        @empty
            <p style="color:var(--c-muted); font-size:0.875rem; text-align:center; padding:24px 0;">
                Nothing here. Great work! ✅
            </p>
        @endforelse
    </div>

</div>

@endsection
