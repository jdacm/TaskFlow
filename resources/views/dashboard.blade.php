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

{{-- Quick Actions --}}
<div class="card" style="margin-bottom:32px;">
    <h2 style="font-size:1rem; font-weight:700; margin:0 0 16px 0;">Quick Actions</h2>
    <div style="display:flex; gap:12px; flex-wrap:wrap;">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            New Task
        </a>
        <a href="{{ route('tasks.index', ['status' => 'pending']) }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            View Pending
        </a>
        <a href="{{ route('tasks.index', ['due_date' => today()->format('Y-m-d')]) }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Today's Tasks
        </a>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            Manage Subjects
        </a>
    </div>
</div>

{{-- Quick Add Task --}}
<div class="card" style="margin-bottom:32px;">
    <h2 style="font-size:1rem; font-weight:700; margin:0 0 16px 0;">Quick Add Task</h2>
    <form method="POST" action="{{ route('tasks.store') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        @csrf
        <div style="flex:1; min-width:200px;">
            <label class="form-label" style="margin-bottom:6px;">Task Title</label>
            <input type="text" name="title" class="form-input" placeholder="What needs to be done?" required>
        </div>
        <div style="min-width:140px;">
            <label class="form-label" style="margin-bottom:6px;">Due Date</label>
            <input type="date" name="due_date" class="form-input" value="{{ today()->format('Y-m-d') }}" required>
        </div>
        <div style="min-width:120px;">
            <label class="form-label" style="margin-bottom:6px;">Priority</label>
            <select name="priority_id" class="form-input">
                <option value="">No Priority</option>
                @foreach(\App\Models\Priority::where('user_id', Auth::id())->get() as $priority)
                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Task
        </button>
    </form>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

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
                    <a href="{{ route('tasks.show', $task) }}" style="color:{{ $task->isCompleted() ? 'var(--c-muted)' : 'var(--c-text)' }}; text-decoration:none; font-weight:500; font-size:0.875rem; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; {{ $task->isCompleted() ? 'text-decoration:line-through;' : '' }}">
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
                    <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-muted); text-decoration:none; font-weight:500; font-size:0.875rem; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; text-decoration:line-through;">
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

<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px;">

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
