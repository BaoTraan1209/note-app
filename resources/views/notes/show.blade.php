@php
    use Illuminate\Support\Facades\Route;

    $noteTags = collect($note->tags ?? []);
    $updateUrl = Route::has('notes.update') ? route('notes.update', $note->id) : '#';
    $deleteUrl = Route::has('notes.destroy') ? route('notes.destroy', $note->id) : '#';
    $canEdit = $canEdit ?? true;
    $isOwner = $isOwner ?? true;
    $availableTags = collect($availableTags ?? []);
    $selectedTags = collect(old('tags', $noteTags->pluck('name')->all()))
        ->flatMap(fn ($tag) => preg_split('/,/', (string) $tag) ?: [])
        ->map(fn ($tag) => trim($tag))
        ->filter()
        ->unique()
        ->values();
    $selectedTagNames = $selectedTags->map(fn ($tag) => mb_strtolower($tag))->all();
    $editorContent = old('content', $note->content);
    $inlineImages = collect($note->images ?? [])
        ->filter(fn ($image) => ! str_contains($editorContent ?? '', asset('storage/'.$image)))
        ->values();
@endphp

@extends('layouts.app')

@section('title', $note->title . ' - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'Note')

@section('content')
    <form class="note-form-layout note-form-layout-wide"
          method="POST"
          enctype="multipart/form-data"
          action="{{ $updateUrl }}"
          @if($canEdit) data-note-form data-note-id="{{ $note->id }}" data-autosave-url="{{ $updateUrl }}" data-autosave-mode="edit" data-realtime-channel="private-notes.{{ $note->id }}" @endif>
        @csrf
        @method('PUT')

        <section class="editor-panel editor-panel-large">
            <div class="editor-topline">
                <a class="btn-secondary" href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                @if ($canEdit)
                    <div class="autosave-state" data-save-state>
                        <i class="bi bi-cloud-check"></i>
                        <span>Saved</span>
                    </div>
                @endif
            </div>

            <input class="title-input"
                   name="title"
                   type="text"
                   value="{{ old('title', $note->title) }}"
                   placeholder="Untitled note"
                   required
                   autofocus
                   {{ $canEdit ? '' : 'readonly' }}
                   @if($canEdit) data-autosave-field @endif>

            @if ($canEdit)
            <div class="editor-toolbar" aria-label="Formatting tools">
                <button class="icon-btn" type="button" data-editor-command="bold" title="Bold">
                    <i class="bi bi-type-bold"></i>
                </button>
                <button class="icon-btn" type="button" data-editor-command="italic" title="Italic">
                    <i class="bi bi-type-italic"></i>
                </button>
                <button class="icon-btn" type="button" data-editor-command="underline" title="Underline">
                    <i class="bi bi-type-underline"></i>
                </button>
                <button class="icon-btn" type="button" data-editor-command="uppercase" title="Uppercase">
                    <i class="bi bi-alphabet-uppercase"></i>
                </button>
                <label class="icon-btn inline-image-button" title="Attach images">
                    <i class="bi bi-image"></i>
                    <input name="images[]" type="file" accept="image/*" multiple>
                </label>
                <label class="toolbar-size-control" title="Text size">
                    <i class="bi bi-type"></i>
                    <input name="font_size"
                           type="number"
                           min="14"
                           max="28"
                           value="{{ old('font_size', $note->font_size ?? 16) }}"
                           data-font-size-control
                           data-autosave-field>
                </label>
            </div>
            @endif

            <input type="hidden" name="content" value="{{ $editorContent }}" data-content-input>
            <div class="content-editor rich-content-editor"
                 style="--note-font-size: {{ old('font_size', $note->font_size ?? 16) }}px;"
                 contenteditable="{{ $canEdit ? 'true' : 'false' }}"
                 role="textbox"
                 aria-multiline="true"
                 data-rich-editor
                 @if($canEdit) data-autosave-field @endif>{!! $editorContent !!}@foreach ($inlineImages as $image)<img class="inline-note-image" src="{{ asset('storage/'.$image) }}" alt="Note image">@endforeach</div>
        </section>

        <aside class="settings-panel">
            <div class="settings-block">
                <div class="settings-title">Status</div>
                <label class="switch-row">
                    <span><i class="bi bi-pin-angle"></i> Pin note</span>
                    <input type="checkbox"
                           name="is_pinned"
                           value="1"
                           {{ old('is_pinned', $note->pinned_at) ? 'checked' : '' }}
                           @if($canEdit) data-autosave-field @endif
                           {{ $isOwner ? '' : 'disabled' }}>
                </label>
            </div>

            <div class="settings-block">
                <div class="settings-title">Tags</div>
                <div class="tag-editor" data-tag-editor>
                    <div class="tag-list" data-tag-list>
                        @foreach ($selectedTags as $tag)
                            <span class="editable-tag" data-tag-item>
                                <button class="editable-tag-text" type="button" data-tag-edit {{ $isOwner ? '' : 'disabled' }}>{{ $tag }}</button>
                                @if ($isOwner)
                                    <button class="editable-tag-remove" type="button" data-tag-remove aria-label="Remove {{ $tag }}">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @endif
                                <input type="hidden" name="tags[]" value="{{ $tag }}" @if($canEdit) data-autosave-field @endif>
                            </span>
                        @endforeach
                    </div>
                    @if ($isOwner)
                        <input class="compact-input" type="text" placeholder="Add tag and press Enter" data-tag-input>
                        @if ($availableTags->isNotEmpty())
                            <select class="filter-select" data-existing-tag-select aria-label="Choose existing tag">
                                <option value="">Choose existing tag</option>
                                @foreach ($availableTags as $tag)
                                    @unless (in_array(mb_strtolower($tag->name), $selectedTagNames, true))
                                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                    @endunless
                                @endforeach
                            </select>
                        @endif
                    @endif
                </div>
                @if ($isOwner)
                    <p class="muted">Press Enter to add a tag. Double-click a tag to rename it.</p>
                @endif
            </div>

            @if ($canEdit)
            @endif

            @if ($isOwner)
                <div class="settings-block">
                    <div class="settings-title">Security and sharing</div>
                    <a class="btn-secondary" href="{{ route('notes.password.edit', $note->id) }}"><i class="bi bi-lock"></i> {{ $note->password ? 'Change password' : 'Lock note' }}</a>
                    <a class="btn-secondary" href="{{ route('notes.share.edit', $note->id) }}"><i class="bi bi-people"></i> Share note</a>
                </div>

                <div class="settings-block">
                    <div class="settings-title">Shared with</div>
                    @forelse ($note->shareUsers as $shareUser)
                        <div class="shared-person">
                            <span class="avatar small">{{ $shareUser->initials() }}</span>
                            <div>
                                <strong>{{ $shareUser->display_name ?: $shareUser->name ?: $shareUser->email }}</strong>
                                <small>{{ $shareUser->email }} - {{ $shareUser->pivot->permission === 'edit' ? 'Can edit' : 'Read only' }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="muted">This note is only visible to you.</p>
                    @endforelse
                </div>
            @else
                <div class="settings-block">
                    <div class="settings-title">Shared access</div>
                    <span class="badge"><i class="bi bi-people"></i> {{ $canEdit ? 'Can edit' : 'Read only' }}</span>
                </div>
            @endif



            <div class="settings-block">
                <div class="settings-title">Actions</div>
                @if ($isOwner)
                <button class="btn-secondary"
                        type="button"
                        onclick="document.getElementById('delete-note-form').requestSubmit()">
                    <i class="bi bi-trash"></i> Delete
                </button>
                @endif
            </div>
        </aside>
    </form>

    <form id="delete-note-form" class="inline-form" method="POST" action="{{ $deleteUrl }}" data-confirm="Delete this note permanently?">
        @csrf
        @method('DELETE')
    </form>
@endsection

