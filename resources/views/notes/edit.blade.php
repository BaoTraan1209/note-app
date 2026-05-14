@php
    $labels = isset($labels) ? collect($labels) : collect();
    $noteLabels = collect($note->labels ?? [])->pluck('id')->all();
    $updateUrl = Route::has('notes.update') ? route('notes.update', $note->id) : '#';
    $showUrl = Route::has('notes.show') ? route('notes.show', $note->id) : '#';
@endphp

@extends('layouts.app')

@section('title', 'Edit note - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'Edit note')

@section('content')
    <form class="note-form-layout" method="POST" action="{{ $updateUrl }}" data-loading-form>
        @csrf
        @method('PUT')

        <section class="editor-panel">
            <input class="title-input" name="title" type="text" value="{{ old('title', $note->title) }}" placeholder="Untitled note" required autofocus>
            <textarea class="content-editor" name="content" placeholder="Write your note..." required>{{ old('content', $note->content) }}</textarea>
            <div class="notice notice-success">
                <i class="bi bi-cloud-check"></i>
                <span>Last updated {{ optional($note->updated_at)->diffForHumans() ?? 'recently' }}.</span>
            </div>
        </section>

        <aside class="settings-panel">
            <div class="settings-block">
                <div class="settings-title">Actions</div>
                <button class="btn-primary" type="submit"><i class="bi bi-check-lg"></i> Save changes</button>
                <a class="btn-secondary" href="{{ $showUrl }}"><i class="bi bi-eye"></i> Preview</a>
            </div>

            <div class="settings-block">
                <div class="settings-title">Status</div>
                <label class="switch-row">
                    <span><i class="bi bi-pin-angle"></i> Pin note</span>
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $note->is_pinned) ? 'checked' : '' }}>
                </label>
            </div>

            <div class="settings-block">
                <div class="settings-title">Color</div>
                <div class="color-options">
                    @foreach (['' => '#ffffff', 'yellow' => '#fff4cc', 'green' => '#e6f8ef', 'blue' => '#e6f1ff', 'rose' => '#ffe9e6', 'lav' => '#eee9ff'] as $value => $color)
                        <label class="color-check">
                            <input type="radio" name="color" value="{{ $value }}" {{ old('color', $note->color ?? '') === $value ? 'checked' : '' }}>
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
                            <input type="checkbox" name="labels[]" value="{{ $label->id }}" {{ in_array($label->id, old('labels', $noteLabels)) ? 'checked' : '' }}>
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
