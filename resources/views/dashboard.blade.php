{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="dashboard-stat-grid">
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
    <div class="stat-card" style="border: 1px solid {{ $colors['border_color'] ?? 'var(--c-border)' }}; background: {{ $colors['bg_color'] ?? 'var(--c-background)' }};">
        <div class="stat-number" style="font-size:2.5rem; font-weight:900; {{ $colors['text_color'] ?? 'color:var(--c-accent-light)' }};">{{ $productivityData['productivity_score'] }}%</div>
        <div class="stat-label">Productivity Score</div>
        <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:9999px; overflow:hidden; margin-top:8px;">
            <div style="height:100%; width:{{ $productivityData['productivity_score'] }}%; background:{{ $colors['progress_color'] ?? 'var(--c-accent-light)' }}; border-radius:9999px;"></div>
        </div>
    </div>
</div>
<div class="dashboard-two-col-grid">

    {{-- Today's Tasks --}}
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="font-size:1rem; font-weight:700; margin:0;">Today's Tasks</h2>
            <a href="{{ route('tasks.index', ['due_date' => today()->format('Y-m-d')]) }}" style="font-size:0.8rem; color:var(--c-accent-light); text-decoration:none;">View all →</a>
        </div>

        @forelse($todaysTasks as $task)
            <div class="task-row">
                {{-- Toggle complete button --}}
                <form method="POST" action="{{ route('tasks.toggle-complete', $task) }}">
                    @csrf @method('PATCH')
                    <button type="submit" style="width:18px;height:18px;border-radius:50%;border:2px solid var(--c-border);background:none;cursor:pointer;flex-shrink:0;" title="Mark complete">
                        @if($task->isCompleted())
                            <svg width="12" height="12" fill="var(--c-success)" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                        @endif
                    </button>
                </form>

                <div style="flex:1; min-width:0;">
                    <a href="{{ route('tasks.show', $task) }}" style="color:{{ $task->isCompleted() ? 'var(--c-muted)' : 'var(--c-text)' }}; text-decoration:none; font-weight:500; font-size:0.875rem; display:block; overflow:hidden; text-overflow:ellipsis; {{ $task->isCompleted() ? 'text-decoration:line-through;' : '' }}">
                        {{ $task->title }}
                    </a>
                    <div style="font-size:0.75rem; color:var(--c-muted); margin-top:2px;">
                        Today
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
                📅 No tasks due today. Enjoy your day!
            </p>
        @endforelse
    </div>

    {{-- Recent Completed Tasks --}}
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="font-size:1rem; font-weight:700; margin:0;">Recently Completed</h2>
            <a href="{{ route('tasks.index', ['status' => 'completed']) }}" style="font-size:0.8rem; color:var(--c-accent-light); text-decoration:none;">View all →</a>
        </div>

        @forelse($recentCompleted as $task)
            <div class="task-row">
                <div style="width:18px;height:18px;border-radius:50%;border:2px solid var(--c-success);background:var(--c-success);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="10" height="10" fill="white" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                </div>

                <div style="flex:1; min-width:0;">
                    <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-muted); text-decoration:none; font-weight:500; font-size:0.875rem; display:block; overflow:hidden; text-overflow:ellipsis; text-decoration:line-through;">
                        {{ $task->title }}
                    </a>
                    <div style="font-size:0.75rem; color:var(--c-muted); margin-top:2px;">
                        Completed {{ $task->updated_at->diffForHumans() }}
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
                No completed tasks yet. Keep it up! 💪
            </p>
        @endforelse
    </div>

</div>

<div class="dashboard-two-col-grid" style="margin-top:24px;">

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
                    <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-text); text-decoration:none; font-weight:500; font-size:0.875rem; display:block; overflow:hidden; text-overflow:ellipsis;">
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
                    <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-text); text-decoration:none; font-weight:500; font-size:0.875rem; display:block; overflow:hidden; text-overflow:ellipsis;">
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

{{-- Productivity Tip --}}
<div class="card" style="margin-top:24px; background: linear-gradient(135deg, rgba(124,106,247,0.1) 0%, rgba(124,106,247,0.05) 100%); border: 1px solid rgba(124,106,247,0.2);">
    <div style="display:flex; align-items:center; gap:12px;">
        <div style="font-size:2rem;">💡</div>
        <div>
            <h3 style="font-size:1rem; font-weight:600; margin:0 0 4px 0; color:var(--c-accent);">Productivity Tip</h3>
            <p style="margin:0; color:var(--c-muted); font-size:0.875rem;">
                @php
                    $tips = [
                        "Break large tasks into smaller, manageable steps.",
                        "Use the Eisenhower Matrix: urgent vs important.",
                        "Set specific time blocks for focused work sessions.",
                        "Review your completed tasks weekly to celebrate progress.",
                        "Prioritize tasks based on impact and deadline proximity."
                    ];
                    $tip = $tips[array_rand($tips)];
                @endphp
                {{ $tip }}
            </p>
        </div>
    </div>
</div>

@endsection
