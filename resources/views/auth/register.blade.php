@extends('layouts.guest')

@section('title', 'Register - NoteNest')

@section('content')
    <main class="guest-shell">
        <section class="auth-card">
            <div class="auth-head">
                <div class="brand"><span class="brand-mark"><i class="bi bi-journal-text"></i></span><span>NoteNest</span></div>
                <span class="badge"><i class="bi bi-envelope-check"></i> Email activation</span>
            </div>

            <div class="title-block">
                <h2>Create account</h2>
                <p class="muted">Use your email, display name, and password to start organizing notes.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i><span>{{ $errors->first() }}</span></div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('register') }}" data-loading-form>
                @csrf
                <div class="field">
                    <label for="name">Display name</label>
                    <div class="input-wrap"><i class="bi bi-person"></i><input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus></div>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-wrap"><i class="bi bi-envelope"></i><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required></div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap"><i class="bi bi-lock"></i><input id="password" name="password" type="password" autocomplete="new-password" required><button class="password-toggle" type="button" data-password-toggle data-target="password"><i class="bi bi-eye"></i></button></div>
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="input-wrap"><i class="bi bi-shield-lock"></i><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required><button class="password-toggle" type="button" data-password-toggle data-target="password_confirmation"><i class="bi bi-eye"></i></button></div>
                </div>
                <button class="btn-primary" type="submit">Create account</button>
            </form>

            <p class="auth-footer">Already have an account? @if (Route::has('login'))<a href="{{ route('login') }}">Log in</a>@endif</p>
        </section>

        <section class="guest-side">
            <div class="brand"><span class="brand-mark"><i class="bi bi-journal-richtext"></i></span><span>NoteNest</span></div>
            <div class="guest-copy">
                <h1>Start organizing your notes.</h1>
                <p>Create notes, add labels, share securely, protect content, and customize your workspace.</p>
            </div>
            <div class="preview-notes">
                <article class="preview-card yellow"><strong><i class="bi bi-magic"></i> Auto-save</strong><p>Your notes are saved automatically while you write.</p></article>
                <article class="preview-card green"><strong><i class="bi bi-tags"></i> Labels</strong><p>Organize and filter notes with one or more labels.</p></article>
                <article class="preview-card blue"><strong><i class="bi bi-people"></i> Sharing</strong><p>Invite others to view or edit notes with permissions.</p></article>
            </div>
        </section>
    </main>
@endsection
