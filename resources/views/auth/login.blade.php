<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body>
<main class="login-shell">
    <section class="brand-panel" aria-label="Introduce website">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-journal-text"></i></span>
            <span>NoteApp</span>
        </div>

        <div>
            <h1>Log in to your notes space</h1>
            <p class="lead">Managers take notes, stay connected, share information with the team, and continue working even when the connection is unstable.</p>
        </div>

        <div class="floating-notes" aria-hidden="true">
            <article class="note-card">
                <strong><i class="bi bi-pin-angle-fill"></i> Pinned note</strong>
                <p>The important things are always at the top of the list.</p>
            </article>
            <article class="note-card">
                <strong><i class="bi bi-shield-lock-fill"></i> Security</strong>
                <p>Each note can be password-protected when needed.</p>
            </article>
            <article class="note-card">
                <strong><i class="bi bi-cloud-check-fill"></i> Offline ready</strong>
                <p>Review cached and synced content while online.</p>
            </article>
        </div>
    </section>

    <section class="login-card" aria-label="Login form">
        <div class="card-content">
            <div class="card-top">
                <div class="brand">
                    <span class="brand-mark"><i class="bi bi-journal-richtext"></i></span>
                    <span>NoteNest</span>
                </div>
                <span class="secure-badge"><i class="bi bi-shield-check"></i> bcrypt security</span>
            </div>

            <div class="title-block">
                <h2>Welcome Back</h2>
                <p class="subtitle">Log in to view your personal notes page, shared notes, and your preferences.</p>
                </div>

                @if ($errors->any())
                    <div class="alert-box">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>{{ $errors->first() }}</span>
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
                            <button class="password-toggle" type="button" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-tools">
                        <label class="check-row">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button class="login-button" type="submit">
                        <span class="button-text">Log in</span>
                    </button>
                </form>

                <p class="register-line">
                    No account?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @else
                        <a href="#">Register</a>
                    @endif
                </p>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/note-app/login.js') }}"></script>
</body>
</html>
