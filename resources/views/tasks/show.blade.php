{{-- resources/views/tasks/show.blade.php --}}
@extends('layouts.app')
@section('title', $task->title)

@section('content')

<div style="max-width:900px;">
    {{-- Task Header --}}
    <div class="card" style="margin-bottom:24px;">
        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:20px;">
            <div style="flex:1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <h1 style="font-size:1.75rem; font-weight:700; margin:0;">{{ $task->title }}</h1>
                    <span class="badge badge-{{ str_replace('_','-',$task->status) }}">{{ $task->statusLabel() }}</span>
                </div>
                @if($task->isOverdue())
                    <p style="color:var(--c-danger); font-size:0.875rem; margin:0;">⚠️ Overdue since {{ $task->due_date->format('M d, Y') }}</p>
                @endif
            </div>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary">Edit</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

        {{-- Task Metadata --}}
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; padding-top:20px; border-top:1px solid var(--c-border);">
            <div>
                <div style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--c-muted); margin-bottom:8px;">Due Date</div>
                <div style="font-size:1rem; font-weight:600;">{{ $task->due_date->format('M d, Y') }}</div>
            </div>
            <div>
                <div style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--c-muted); margin-bottom:8px;">Subject</div>
                <div>
                    @if($task->subject)
                        <span style="display:inline-flex; align-items:center; gap:8px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $task->subject->color }};"></span>
                            <span style="font-size:1rem; font-weight:600;">{{ $task->subject->name }}</span>
                        </span>
                    @else
                        <span style="color:var(--c-muted);">—</span>
                    @endif
                </div>
            </div>
            <div>
                <div style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--c-muted); margin-bottom:8px;">Priority</div>
                <div>
                    @if($task->priority)
                        <span class="badge" style="background:{{ $task->priority->color }}22; color:{{ $task->priority->color }}; font-size:0.875rem;">
                            {{ $task->priority->name }}
                        </span>
                    @else
                        <span style="color:var(--c-muted);">—</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($task->description)
        <div class="card" style="margin-bottom:24px;">
            <h2 style="font-size:0.9rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--c-muted); margin:0 0 12px;">Description</h2>
            <div style="color:var(--c-text); line-height:1.6; white-space:pre-wrap;">{{ $task->description }}</div>
        </div>
    @endif

    {{-- Status Toggle --}}
    <form method="POST" action="{{ route('tasks.toggle-complete', $task) }}" style="margin-bottom:24px;">
        @csrf @method('PATCH')
        <button type="submit" class="btn {{ $task->isCompleted() ? 'btn-secondary' : 'btn-success' }}">
            @if($task->isCompleted())
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/></svg>
                Mark as Pending
            @else
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Mark as Completed
            @endif
        </button>
    </form>

    {{-- Subtasks Section --}}
    <div class="card" style="margin-bottom:24px;">
        {{-- Subtasks Header with Progress --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div>
                <h2 style="font-size:1rem; font-weight:700; margin:0 0 8px;">Subtasks</h2>
                <div style="font-size:0.875rem; color:var(--c-muted);">
                    {{ $task->subtasks->where('is_completed', true)->count() }} / {{ $task->subtasks->count() }} completed
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        @if($task->subtasks->count() > 0)
            <div style="margin-bottom:20px;">
                <div style="height:6px; background:rgba(255,255,255,0.05); border-radius:9999px; overflow:hidden; border:1px solid rgba(255,255,255,0.05);">
                    @php
                        $completionPercentage = ($task->subtasks->where('is_completed', true)->count() / $task->subtasks->count()) * 100;
                    @endphp
                    <div style="height:100%; width:{{ $completionPercentage }}%; background:linear-gradient(90deg, #10b981 0%, #34d399 100%); transition:width 0.6s ease-out; border-radius:9999px;"></div>
                </div>
            </div>
        @endif

        {{-- Subtasks List --}}
        @forelse($task->subtasks->sortBy('is_completed') as $subtask)
            <div style="display:flex; align-items:center; gap:12px; padding:12px; background:rgba(255,255,255,0.02); border-radius:8px; margin-bottom:8px; transition:all 0.2s ease; {{ $subtask->is_completed ? 'opacity:0.6;' : '' }}">
                {{-- Checkbox Toggle --}}
                <form method="POST" action="{{ route('subtasks.toggle', $subtask) }}" style="flex-shrink:0;">
                    @csrf @method('PATCH')
                    <button type="submit" style="width:20px; height:20px; border-radius:6px; border:2px solid {{ $subtask->is_completed ? '#10b981' : 'rgba(255,255,255,0.2)' }}; background:{{ $subtask->is_completed ? '#10b981' : 'transparent' }}; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s ease; padding:0;" title="Toggle subtask">
                        @if($subtask->is_completed)
                            <svg width="12" height="12" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        @endif
                    </button>
                </form>

                {{-- Subtask Title --}}
                <div style="flex:1; {{ $subtask->is_completed ? 'text-decoration:line-through; color:var(--c-muted);' : 'color:var(--c-text);' }} font-size:0.875rem;">
                    {{ $subtask->title }}
                </div>

                {{-- Delete Button --}}
                <form method="POST" action="{{ route('subtasks.destroy', $subtask) }}" onsubmit="return confirm('Delete this subtask?')" style="flex-shrink:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:var(--c-danger); cursor:pointer; padding:4px; display:flex; align-items:center; justify-content:center; hover:opacity:0.8; transition:opacity 0.2s;" title="Delete subtask">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </form>
            </div>
        @empty
            <p style="color:var(--c-muted); font-size:0.875rem; text-align:center; padding:20px 0;">
                No subtasks yet. Add one to break down this task!
            </p>
        @endforelse

        {{-- Add Subtask Form --}}
        <div style="margin-top:20px; padding-top:20px; border-top:1px solid var(--c-border);">
            <form method="POST" action="{{ route('subtasks.store', $task) }}" style="display:flex; gap:8px;">
                @csrf
                <input
                    type="text"
                    name="title"
                    placeholder="Add a subtask..."
                    class="form-input"
                    style="flex:1; font-size:0.875rem;"
                    required
                >
                <button type="submit" class="btn btn-primary btn-sm" style="white-space:nowrap;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add
                </button>
            </form>
            @error('title') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="card">
        <h2 style="font-size:1rem; font-weight:700; margin:0 0 20px;">Comments ({{ count($task->comments) }})</h2>

        {{-- Add Comment Form --}}
        <form method="POST" action="{{ route('tasks.comments.store', $task) }}" style="margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid var(--c-border);">
            @csrf
            <div style="margin-bottom:12px;">
                <textarea
                    name="body"
                    placeholder="Add a comment..."
                    rows="2"
                    class="form-input"
                    style="resize:vertical;"
                ></textarea>
                @error('body') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
        </form>

        {{-- Comments List --}}
        @forelse($task->comments as $comment)
            <div style="padding:16px 0; border-bottom:1px solid var(--c-border);">
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <div style="font-weight:600; font-size:0.875rem;">{{ $comment->user->name }}</div>
                    <div style="font-size:0.75rem; color:var(--c-muted);">{{ $comment->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div style="color:var(--c-text); line-height:1.5; white-space:pre-wrap;">{{ $comment->body }}</div>
            </div>
        @empty
            <p style="color:var(--c-muted); font-size:0.875rem; text-align:center; padding:24px 0;">
                No comments yet. Be the first to comment!
            </p>
        @endforelse
    </div>
</div>

@endsection
