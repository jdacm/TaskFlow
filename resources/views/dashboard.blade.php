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

{{-- Productivity Score Card --}}
<div class="card" style="margin-bottom:32px; border: 1px solid {{ $colors['border_color'] ?? 'var(--c-border)' }}; background: {{ $colors['bg_color'] ?? 'var(--c-background)' }};">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="font-size:1rem; font-weight:700; margin:0; color:var(--c-text);">Productivity Score</h2>
            <p style="font-size:0.75rem; color:var(--c-muted); margin:4px 0 0 0;">{{ $productivityData['week_start'] }} — {{ $productivityData['week_end'] }}</p>
        </div>
        <div style="text-align:right;">
            <div style="font-size:2.5rem; font-weight:900; {{ $colors['text_color'] ?? 'text-accent-light' }}; line-height:1;">
                {{ $productivityData['productivity_score'] }}%
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:12px; margin-bottom:20px;">
        <div style="padding:12px; background:rgba(255,255,255,0.02); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
            <div style="font-size:0.75rem; color:var(--c-muted); margin-bottom:4px;">Completed</div>
            <div style="font-size:1.375rem; font-weight:700; color:var(--c-success);">{{ $productivityData['completed_tasks'] }}</div>
        </div>
        <div style="padding:12px; background:rgba(255,255,255,0.02); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
            <div style="font-size:0.75rem; color:var(--c-muted); margin-bottom:4px;">Total</div>
            <div style="font-size:1.375rem; font-weight:700; color:var(--c-accent-light);">{{ $productivityData['total_tasks'] }}</div>
        </div>
        <div style="padding:12px; background:rgba(255,255,255,0.02); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
            <div style="font-size:0.75rem; color:var(--c-muted); margin-bottom:4px;">In Progress</div>
            <div style="font-size:1.375rem; font-weight:700; color:#818cf8;">{{ $productivityData['in_progress_tasks'] }}</div>
        </div>
        <div style="padding:12px; background:rgba(255,255,255,0.02); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
            <div style="font-size:0.75rem; color:var(--c-muted); margin-bottom:4px;">Overdue</div>
            <div style="font-size:1.375rem; font-weight:700; color:var(--c-danger);">{{ $productivityData['overdue_tasks'] }}</div>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div style="margin-bottom:16px;">
        <div style="height:8px; background:rgba(255,255,255,0.05); border-radius:9999px; overflow:hidden; border:1px solid rgba(255,255,255,0.05);">
            <div style="height:100%; width:{{ $productivityData['productivity_score'] }}%; background:{{ $colors['progress_color'] ?? 'var(--c-accent-light)' }}; transition:width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1); border-radius:9999px; box-shadow:0 0 12px {{ $colors['progress_color'] ?? 'var(--c-accent-light)' }}88;"></div>
        </div>
    </div>

    {{-- Motivational Message --}}
    <div style="padding:12px 16px; background:rgba(255,255,255,0.05); border-radius:8px; border-left:3px solid {{ $colors['progress_color'] ?? 'var(--c-accent-light)' }}; text-align:center;">
        <p style="margin:0; font-size:0.875rem; color:var(--c-text); font-weight:500;">
            {{ $message }}
        </p>
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
