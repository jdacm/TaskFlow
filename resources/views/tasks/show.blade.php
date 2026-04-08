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
