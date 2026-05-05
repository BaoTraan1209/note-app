<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body>
<main class="auth-page">
    <section class="brand-side">
        <div class="brand-lockup">
            <span class="brand-mark"><i class="bi bi-journal-richtext"></i></span>
            <span>NoteNest</span>
        </div>

        <div class="hero-copy">
            <h1>Your notes, organized.</h1>
            <p class="lead">Sign in to manage notes, labels, pinned items, shared work, and protected content from one clean dashboard.</p>
        </div>

        <div class="preview-notes" aria-hidden="true">
            <article class="preview-card yellow">
                <strong><i class="bi bi-pin-angle-fill"></i> Pinned</strong>
                <p>Keep important notes at the top.</p>
            </article>
            <article class="preview-card green">
                <strong><i class="bi bi-tags"></i> Labels</strong>
                <p>Filter notes by project or topic.</p>
            </article>
            <article class="preview-card blue">
                <strong><i class="bi bi-people-fill"></i> Shared</strong>
                <p>Work with teammates in one place.</p>
            </article>
        </div>
    </section>

    <section class="login-card">
        <div class="card-head">
            <div class="brand">
                <span class="brand-mark"><i class="bi bi-journal-text"></i></span>
                <span>NoteNest</span>
            </div>
            <span class="badge"><i class="bi bi-shield-check"></i> Secure login</span>
        </div>

        <div class="title-block">
            <h2>Welcome back</h2>
            <p class="subtitle">Log in to open your personal note dashboard.</p>
        </div>

        @if ($errors->any())
            <div class="alert-box">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if (session('status'))
            <div class="alert-box">
                <i class="bi bi-info-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form id="loginForm" action="{{ route('login') }}" method="post">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                    <button class="password-toggle" type="button" data-target="password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                </div>
            </div>

            <div class="form-row">
                <label class="remember">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <button class="login-btn" type="submit"><span class="btn-text">Log in</span></button>
        </form>

        <p class="register-line">
            New to NoteNest?
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Create an account</a>
            @else
                <a href="#">Create an account</a>
            @endif
        </p>
    </section>
</main>

<script src="{{ asset('js/note-app/login.js') }}"></script>
</body>
</html>
