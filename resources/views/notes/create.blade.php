@php
    $labels = isset($labels) ? collect($labels) : collect();
    $storeUrl = Route::has('notes.store') ? route('notes.store') : '#';
@endphp

@extends('layouts.app')

@section('title', 'New note - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'New note')

@section('content')
    <form class="note-form-layout" method="POST" action="{{ $storeUrl }}" data-loading-form>
        @csrf

        <section class="editor-panel">
            <input class="title-input" name="title" type="text" value="{{ old('title') }}" placeholder="Untitled note" required autofocus>
            <textarea class="content-editor" name="content" placeholder="Write your note..." required>{{ old('content') }}</textarea>
            <div class="notice notice-success">
                <i class="bi bi-cloud-check"></i>
                <span>Tip: connect this form to auto-save later. For now, submit saves the note.</span>
            </div>
        </section>

        <aside class="settings-panel">
            <div class="settings-block">
                <div class="settings-title">Actions</div>
                <button class="btn-primary" type="submit"><i class="bi bi-check-lg"></i> Create note</button>
                <a class="btn-secondary" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}"><i class="bi bi-arrow-left"></i> Back</a>
            </div>

            <div class="settings-block">
                <div class="settings-title">Status</div>
                <label class="switch-row">
                    <span><i class="bi bi-pin-angle"></i> Pin note</span>
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}>
                </label>
            </div>

            <div class="settings-block">
                <div class="settings-title">Color</div>
                <div class="color-options">
                    @foreach (['' => '#ffffff', 'yellow' => '#fff4cc', 'green' => '#e6f8ef', 'blue' => '#e6f1ff', 'rose' => '#ffe9e6', 'lav' => '#eee9ff'] as $value => $color)
                        <label class="color-check">
                            <input type="radio" name="color" value="{{ $value }}" {{ old('color', '') === $value ? 'checked' : '' }}>
                            <span style="background: {{ $color }}"></span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="settings-block">
                <div class="settings-title">Labels</div>
                <div class="label-checks">
                    @forelse ($labels as $label)
                        <label class="label-check">
                            <input type="checkbox" name="labels[]" value="{{ $label->id }}" {{ in_array($label->id, old('labels', [])) ? 'checked' : '' }}>
                            <span>{{ $label->name }}</span>
                        </label>
                    @empty
                        <p class="muted">No labels yet.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </form>
@endsection
