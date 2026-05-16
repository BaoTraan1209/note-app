@php
    $storeUrl = Route::has('notes.store') ? route('notes.store') : '#';
    $oldTags = collect(old('tags', []))
        ->flatMap(fn ($tag) => preg_split('/,/', (string) $tag) ?: [])
        ->map(fn ($tag) => trim($tag))
        ->filter()
        ->unique()
        ->values();
    $availableTags = collect($availableTags ?? []);
    $selectedTagNames = $oldTags->map(fn ($tag) => mb_strtolower($tag))->all();
    $oldShareEmails = collect(preg_split('/[\s,;]+/', old('share_emails', '')) ?: [])
        ->map(fn ($email) => strtolower(trim($email)))
        ->filter()
        ->unique()
        ->values();
@endphp

@extends('layouts.app')

@section('title', 'New note - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'New note')

@section('content')
    <form class="note-form-layout"
          method="POST"
          action="{{ $storeUrl }}"
          enctype="multipart/form-data"
          data-note-form
          data-autosave-url="{{ $storeUrl }}"
          data-autosave-mode="create">
        @csrf

        <section class="editor-panel">
            <div class="editor-topline">
                <a class="btn-secondary" href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <div class="autosave-state" data-save-state>
                    <i class="bi bi-cloud-check"></i>
                    <span>Saved</span>
                </div>
            </div>

            <input class="title-input" name="title" type="text" value="{{ old('title') }}" placeholder="Untitled note" required autofocus data-autosave-field>
            <div class="editor-toolbar" aria-label="Formatting tools">
                <button class="icon-btn" type="button" data-editor-command="bold" title="Bold"><i class="bi bi-type-bold"></i></button>
                <button class="icon-btn" type="button" data-editor-command="italic" title="Italic"><i class="bi bi-type-italic"></i></button>
                <button class="icon-btn" type="button" data-editor-command="underline" title="Underline"><i class="bi bi-type-underline"></i></button>
                <button class="icon-btn" type="button" data-editor-command="uppercase" title="Uppercase"><i class="bi bi-alphabet-uppercase"></i></button>
                <label class="icon-btn inline-image-button" title="Attach images"><i class="bi bi-image"></i><input name="images[]" type="file" accept="image/*" multiple></label>
                <label class="toolbar-size-control" title="Text size">
                    <i class="bi bi-type"></i>
                    <input name="font_size" type="number" min="14" max="28" value="{{ old('font_size', 16) }}" data-font-size-control data-autosave-field>
                </label>
            </div>
            <input type="hidden" name="content" value="{{ old('content') }}" data-content-input>
            <div class="content-editor rich-content-editor"
                 style="--note-font-size: {{ old('font_size', 16) }}px;"
                 contenteditable="true"
                 role="textbox"
                 aria-multiline="true"
                 data-rich-editor
                 data-autosave-field>{!! old('content') !!}</div>
        </section>

        <aside class="settings-panel">
            <div class="settings-block">
                <div class="settings-title">Actions</div>
                <a class="btn-secondary" href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}"><i class="bi bi-journal-text"></i> All notes</a>
            </div>

            <div class="settings-block">
                <div class="settings-title">Status</div>
                <label class="switch-row">
                    <span><i class="bi bi-pin-angle"></i> Pin note</span>
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} data-autosave-field>
                </label>
            </div>

            <div class="settings-block">
                <div class="settings-title">Tags</div>
                <div class="tag-editor" data-tag-editor>
                    <div class="tag-list" data-tag-list>
                        @foreach ($oldTags as $tag)
                            <span class="editable-tag" data-tag-item>
                                <button class="editable-tag-text" type="button" data-tag-edit>{{ $tag }}</button>
                                <button class="editable-tag-remove" type="button" data-tag-remove aria-label="Remove {{ $tag }}">
                                    <i class="bi bi-x"></i>
                                </button>
                                <input type="hidden" name="tags[]" value="{{ $tag }}" data-autosave-field>
                            </span>
                        @endforeach
                    </div>
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
                </div>
                <p class="muted">Press Enter to add a tag. Double-click a tag to rename it.</p>
            </div>

            <div class="settings-block">
                <div class="settings-title">Password protection</div>
                <div class="field">
                    <label for="password">Note password</label>
                    <div class="input-wrap"><i class="bi bi-lock"></i><input id="password" name="password" type="password" autocomplete="new-password"><button class="password-toggle" type="button" data-password-toggle data-target="password"><i class="bi bi-eye"></i></button></div>
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="input-wrap"><i class="bi bi-shield-lock"></i><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"><button class="password-toggle" type="button" data-password-toggle data-target="password_confirmation"><i class="bi bi-eye"></i></button></div>
                </div>
            </div>

            <div class="settings-block">
                <div class="settings-title">Share on create</div>
                <div class="field">
                    <label for="share_emails">Recipient emails</label>
                    <input id="share_emails" name="share_emails" type="hidden" value="{{ $oldShareEmails->implode(', ') }}" data-share-email-value>
                    <div class="tag-editor" data-email-editor>
                        <div class="tag-list" data-email-list>
                            @foreach ($oldShareEmails as $email)
                                <span class="editable-tag" data-email-item data-email-value="{{ $email }}">
                                    <button class="editable-tag-text" type="button">{{ $email }}</button>
                                    <button class="editable-tag-remove" type="button" data-email-remove aria-label="Remove {{ $email }}">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                        <input class="compact-input" type="email" placeholder="Type email and press Enter" data-email-input>
                    </div>
                    <p class="muted">Press Enter or comma after each email. Keep adding recipients before or after the note is created.</p>
                </div>
                <div class="field">
                    <label for="share_permission">Permission</label>
                    <select class="filter-select" id="share_permission" name="share_permission">
                        <option value="read" {{ old('share_permission') === 'read' ? 'selected' : '' }}>Read only</option>
                        <option value="edit" {{ old('share_permission') === 'edit' ? 'selected' : '' }}>Can edit</option>
                    </select>
                </div>
            </div>
        </aside>
    </form>
@endsection
