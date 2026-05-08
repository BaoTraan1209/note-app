@extends('layouts.guest')

@section('title', 'Login - NoteNest')

@section('content')
    <main class="guest-shell">
        <section class="guest-side">
            <div class="brand"><span class="brand-mark"><i class="bi bi-journal-richtext"></i></span><span>NoteNest</span></div>
            <div class="guest-copy">
                <h1>Your notes, organized.</h1>
                <p>Sign in to manage notes, labels, pinned items, shared work, and protected content from one clean dashboard.</p>
            </div>
            <div class="preview-notes">
                <article class="preview-card yellow"><strong><i class="bi bi-pin-angle-fill"></i> Pinned</strong><p>Keep important notes at the top.</p></article>
                <article class="preview-card green"><strong><i class="bi bi-tags"></i> Labels</strong><p>Filter notes by project or topic.</p></article>
                <article class="preview-card blue"><strong><i class="bi bi-people-fill"></i> Shared</strong><p>Work with teammates in one place.</p></article>
            </div>
        </section>

        <section class="auth-card">
            <div class="auth-head">
                <div class="brand"><span class="brand-mark"><i class="bi bi-journal-text"></i></span><span>NoteNest</span></div>
                <span class="badge"><i class="bi bi-shield-check"></i> Secure login</span>
            </div>

            <div class="title-block">
                <h2>Welcome back</h2>
                <p class="muted">Log in to open your personal note dashboard.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i><span>{{ $errors->first() }}</span></div>
            @endif

            @if (session('status'))
                <div class="alert alert-success"><i class="bi bi-check-circle"></i><span>{{ session('status') }}</span></div>
            @endif

            <form class="auth-form" method="POST" action="{{ route('login') }}" data-loading-form>
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-wrap"><i class="bi bi-envelope"></i><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus></div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock"></i>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                        <button class="password-toggle" type="button" data-password-toggle data-target="password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <div class="form-row">
                    <label class="check-row"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
                    @if (Route::has('password.request'))<a href="{{ route('password.request') }}">Forgot password?</a>@endif
                </div>
                <button class="btn-primary" type="submit">Log in</button>
            </form>

            <p class="auth-footer">Don't have account? @if (Route::has('register'))<a href="{{ route('register') }}">Create an account</a>@endif</p>
        </section>
    </main>
@endsection
