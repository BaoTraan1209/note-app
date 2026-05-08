@extends('layouts.app')

@section('title', 'Profile - NoteNest')
@section('eyebrow', 'Account')
@section('page_title', 'Profile')

@section('content')
    <section class="note-form-layout">
        <div class="editor-panel">
            <div class="title-block">
                <h2 class="panel-title">Profile information</h2>
                <p class="muted">Update your display name, email, and avatar details.</p>
            </div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <aside class="settings-panel">
            <div class="settings-block">
                <div class="settings-title">Security</div>
                @include('profile.partials.update-password-form')
            </div>
            <div class="settings-block">
                <div class="settings-title">Danger zone</div>
                @include('profile.partials.delete-user-form')
            </div>
        </aside>
    </section>
@endsection
