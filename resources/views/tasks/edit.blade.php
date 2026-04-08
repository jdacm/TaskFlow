{{-- resources/views/tasks/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <h2 style="font-size:1.25rem; font-weight:700; margin:0 0 24px;">Edit Task</h2>

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf @method('PATCH')

            {{-- Title --}}
            <div style="margin-bottom:18px;">
                <label class="form-label">Title *</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $task->title) }}"
                    class="form-input {{ $errors->has('title') ? 'error' : '' }}"
                    placeholder="What needs to be done?"
                    autofocus
                >
                @error('title') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Description --}}
            <div style="margin-bottom:18px;">
                <label class="form-label">Description</label>
                <textarea
                    name="description"
                    rows="3"
                    class="form-input {{ $errors->has('description') ? 'error' : '' }}"
                    placeholder="Add more details (optional)..."
                    style="resize:vertical;"
                >{{ old('description', $task->description) }}</textarea>
                @error('description') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Row: Due Date + Status --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px;">
                <div>
                    <label class="form-label">Due Date *</label>
                    <input
                        type="date"
                        name="due_date"
                        value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                        class="form-input {{ $errors->has('due_date') ? 'error' : '' }}"
                    >
                    @error('due_date') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input {{ $errors->has('status') ? 'error' : '' }}">
                        <option value="pending"     {{ old('status', $task->status) === 'pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ old('status', $task->status) === 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Row: Subject + Priority --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">
                <div>
                    <label class="form-label">Subject</label>
                    <select name="subject_id" class="form-input">
                        <option value="">— None —</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $task->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Priority</label>
                    <select name="priority_id" class="form-input">
                        <option value="">— None —</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ old('priority_id', $task->priority_id) == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
