{{-- resources/views/subjects/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Subjects')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:1.1rem; font-weight:700; margin:0;">Your Subjects</h2>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Subject
    </a>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:16px;">
    @forelse($subjects as $subject)
        <div class="card">
            <div style="display:flex; align-items:start; justify-content:space-between; margin-bottom:12px;">
                <div>
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:4px;">
                        <span style="width:16px;height:16px;border-radius:50%;background:{{ $subject->color }};"></span>
                        <h3 style="font-size:1rem; font-weight:700; margin:0;">{{ $subject->name }}</h3>
                    </div>
                    <p style="font-size:0.8rem; color:var(--c-muted); margin:0;">{{ $subject->tasks_count }} {{ $subject->tasks_count === 1 ? 'task' : 'tasks' }}</p>
                </div>
                <form method="POST" action="{{ route('subjects.destroy', $subject) }}" onsubmit="return confirm('Delete this subject?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column:1 / -1; text-align:center; padding:48px;">
            <div style="font-size:2rem; margin-bottom:12px;">📚</div>
            <h3 style="font-size:1rem; font-weight:700; margin:0 0 8px;">No subjects yet</h3>
            <p style="color:var(--c-muted); margin:0 0 16px;">Create a subject to organize your tasks</p>
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">Create Subject</a>
        </div>
    @endforelse
</div>

@endsection
