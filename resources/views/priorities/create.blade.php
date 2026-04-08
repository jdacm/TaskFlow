{{-- resources/views/priorities/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Create Priority')

@section('content')

<div style="max-width:520px;">
    <div class="card">
        <h2 style="font-size:1.25rem; font-weight:700; margin:0 0 24px;">New Priority</h2>

        <form method="POST" action="{{ route('priorities.store') }}">
            @csrf

            {{-- Name --}}
            <div style="margin-bottom:18px;">
                <label class="form-label">Name *</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                    placeholder="e.g., Low, Medium, High, Urgent..."
                    autofocus
                >
                @error('name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Level --}}
            <div style="margin-bottom:18px;">
                <label class="form-label">Level *</label>
                <input
                    type="number"
                    name="level"
                    value="{{ old('level') }}"
                    min="1"
                    max="10"
                    class="form-input {{ $errors->has('level') ? 'error' : '' }}"
                    placeholder="1-10 (where 10 is highest)"
                >
                @error('level') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Color --}}
            <div style="margin-bottom:28px;">
                <label class="form-label">Color *</label>
                <div style="display:flex; gap:4px; margin-bottom:12px;">
                    <input
                        type="color"
                        name="color"
                        value="{{ old('color', '#ef4444') }}"
                        class="form-input"
                        style="width:80px; height:40px; padding:4px; cursor:pointer;"
                    >
                    <input
                        type="text"
                        placeholder="#... or name"
                        class="form-input"
                        style="font-family:monospace; font-size:0.85rem;"
                        disabled
                    >
                </div>
                @error('color') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Create Priority
                </button>
                <a href="{{ route('priorities.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
