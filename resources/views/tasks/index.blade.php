{{-- resources/views/tasks/index.blade.php --}}
@extends('layouts.app')
@section('title', 'My Tasks')

@section('content')

{{-- Search & Filter Bar --}}
<form method="GET" action="{{ route('tasks.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px;">
    <div style="flex:1; min-width:200px;">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search tasks..."
            class="form-input"
            style="padding:9px 14px;"
        >
    </div>

    <select name="status" class="form-input" style="width:auto; min-width:140px; padding:9px 14px;">
        <option value="">All Statuses</option>
        <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pending</option>
        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="completed"   {{ request('status') === 'completed'   ? 'selected' : '' }}>Completed</option>
    </select>

    <select name="subject_id" class="form-input" style="width:auto; min-width:140px; padding:9px 14px;">
        <option value="">All Subjects</option>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Search
    </button>

    @if(request()->hasAny(['search','status','subject_id']))
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Clear</a>
    @endif
</form>

{{-- Tasks Table --}}
<div class="card" style="padding:0; overflow:hidden;">
    <table>
        <thead>
            <tr>
                <th style="width:40px;"></th>
                <th>Title</th>
                <th>Subject</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Status</th>
                <th style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    {{-- Toggle complete --}}
                    <td>
                        <form method="POST" action="{{ route('tasks.toggle-complete', $task) }}">
                            @csrf @method('PATCH')
                            <button
                                type="submit"
                                title="{{ $task->isCompleted() ? 'Mark pending' : 'Mark complete' }}"
                                style="
                                    width:20px; height:20px;
                                    border-radius:50%;
                                    border: 2px solid {{ $task->isCompleted() ? 'var(--c-success)' : 'var(--c-border)' }};
                                    background: {{ $task->isCompleted() ? 'rgba(34,197,94,0.2)' : 'transparent' }};
                                    cursor: pointer;
                                    display:flex; align-items:center; justify-content:center;
                                    color: {{ $task->isCompleted() ? 'var(--c-success)' : 'transparent' }};
                                    transition: all 0.15s;
                                "
                            >
                                @if($task->isCompleted())
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                @endif
                            </button>
                        </form>
                    </td>

                    {{-- Title --}}
                    <td>
                        <a href="{{ route('tasks.show', $task) }}" style="color:var(--c-text); text-decoration:none; font-weight:500; {{ $task->isCompleted() ? 'opacity:0.5; text-decoration:line-through;' : '' }}">
                            {{ $task->title }}
                        </a>
                    </td>

                    {{-- Subject --}}
                    <td>
                        @if($task->subject)
                            <span style="display:inline-flex; align-items:center; gap:5px; font-size:0.8rem; color:var(--c-muted);">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $task->subject->color }};"></span>
                                {{ $task->subject->name }}
                            </span>
                        @else
                            <span style="color:var(--c-muted); font-size:0.8rem;">—</span>
                        @endif
                    </td>

                    {{-- Priority --}}
                    <td>
                        @if($task->priority)
                            <span class="badge" style="background:{{ $task->priority->color }}22; color:{{ $task->priority->color }};">
                                {{ $task->priority->name }}
                            </span>
                        @else
                            <span style="color:var(--c-muted); font-size:0.8rem;">—</span>
                        @endif
                    </td>

                    {{-- Due Date --}}
                    <td style="{{ $task->isOverdue() ? 'color:var(--c-danger);' : 'color:var(--c-muted);' }} font-size:0.85rem;">
                        {{ $task->due_date->format('M d, Y') }}
                        @if($task->isOverdue())
                            <span style="font-size:0.7rem; margin-left:4px;">(overdue)</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="badge badge-{{ str_replace('_','-',$task->status) }}">
                            {{ $task->statusLabel() }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Del</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:48px 16px; color:var(--c-muted);">
                        <div style="font-size:2rem; margin-bottom:8px;">📋</div>
                        <div style="font-weight:600; margin-bottom:4px;">No tasks found</div>
                        <div style="font-size:0.8rem;">
                            @if(request()->hasAny(['search','status','subject_id']))
                                Try adjusting your filters.
                            @else
                                <a href="{{ route('tasks.create') }}" style="color:var(--c-accent-light);">Create your first task</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($tasks->hasPages())
    <div style="margin-top:20px; display:flex; justify-content:center; gap:4px;">
        {{ $tasks->links() }}
    </div>
@endif

<div style="margin-top:8px; font-size:0.75rem; color:var(--c-muted);">
    Showing {{ $tasks->firstItem() ?? 0 }}–{{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() }} tasks
</div>

@endsection
