@php
    $preferences = $user->preferences ?? [];
    $theme = old('theme', $preferences['theme'] ?? 'light');
    $defaultView = old('default_view', $preferences['default_view'] ?? 'grid');
@endphp

@extends('layouts.app')

@section('title', 'Preferences - NoteNest')
@section('eyebrow', 'Account')
@section('page_title', 'Preferences')

@section('content')
    <form class="preferences-form" method="POST" action="{{ route('preferences.update') }}" data-preferences-form>
        @csrf
        @method('PATCH')

        <section class="editor-panel">
            <div class="title-block">
                <h2 class="panel-title">User preferences</h2>
            </div>

            <div class="preference-grid">
                <label class="preference-card">
                    <input type="radio" name="theme" value="light" {{ $theme === 'light' ? 'checked' : '' }} data-preference-field>
                    <span><i class="bi bi-sun"></i> Light theme</span>
                    <small>Bright interface for daytime writing.</small>
                </label>
                <label class="preference-card">
                    <input type="radio" name="theme" value="dark" {{ $theme === 'dark' ? 'checked' : '' }} data-preference-field>
                    <span><i class="bi bi-moon-stars"></i> Dark theme</span>
                    <small>Lower contrast for late sessions.</small>
                </label>
            </div>

            <div class="field">
                <label for="default_view">Default notes view</label>
                <select class="filter-select" id="default_view" name="default_view" data-preference-field>
                    <option value="grid" {{ $defaultView === 'grid' ? 'selected' : '' }}>Grid view</option>
                    <option value="list" {{ $defaultView === 'list' ? 'selected' : '' }}>List view</option>
                </select>
            </div>

            <p class="autosave-state" data-preferences-state>
                <i class="bi bi-cloud-check"></i>
                <span>Saved</span>
            </p>
        </section>

    </form>
@endsection
