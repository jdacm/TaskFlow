{{-- resources/views/subjects/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Create Subject')

@section('content')

<div style="max-width:520px;">
    <div class="card">
        <h2 style="font-size:1.25rem; font-weight:700; margin:0 0 24px;">New Subject</h2>

        <form method="POST" action="{{ route('subjects.store') }}">
            @csrf

            {{-- Name --}}
            <div style="margin-bottom:18px;">
                <label class="form-label">Name *</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                    placeholder="e.g., Work, Personal, Projects..."
                    autofocus
                >
                @error('name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Color --}}
            <div style="margin-bottom:28px;">
                <label class="form-label">Color *</label>
                <div style="display:flex; gap:8px; margin-bottom:12px;">
                    @foreach(['#6366f1', '#f59e0b', '#22c55e', '#06b6d4', '#ec4899', '#8b5cf6'] as $color)
                        <input
                            type="radio"
                            name="color"
                            value="{{ $color }}"
                            id="color-{{ $color }}"
                            {{ old('color', '#6366f1') === $color ? 'checked' : '' }}
                            style="appearance:none; width:40px; height:40px; background:{{ $color }}; border:2px solid var(--c-border); border-radius:8px; cursor:pointer; transition:all 0.15s; {{ old('color', '#6366f1') === $color ? 'border-color:var(--c-text);' : '' }}"
                        >
                    @endforeach
                </div>
                <div style="display:flex; gap:4px;">
                    @foreach(['#6366f1', '#f59e0b', '#22c55e', '#06b6d4', '#ec4899', '#8b5cf6'] as $color)
                        <label for="color-{{ $color }}" style="font-size:0.65rem; color:var(--c-muted); width:40px; text-align:center;">
                            @switch($color)
                                @case('#6366f1') Indigo @break
                                @case('#f59e0b') Amber @break
                                @case('#22c55e') Green @break
                                @case('#06b6d4') Cyan @break
                                @case('#ec4899') Pink @break
                                @case('#8b5cf6') Violet @break
                            @endswitch
                        </label>
                    @endforeach
                </div>
                @error('color') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Create Subject
                </button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
