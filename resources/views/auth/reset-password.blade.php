<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset password - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/auth-simple.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-key"></i></span>
            <span>NoteNest</span>
        </div>

        <h1>Reset password</h1>
        <p class="subtitle">Create a new password for your account. After resetting, you will need to log in manually.</p>

        @if ($errors->any())
            <div class="alert-box">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" autocomplete="email" required autofocus>
                </div>
            </div>

            <div class="field">
                <label for="password">New Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input id="password" name="password" type="password" autocomplete="new-password" required>
                    <button class="password-toggle" type="button" aria-label="Show password" data-target="password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm New Password</label>
                <div class="input-wrap">
                    <i class="bi bi-shield-lock"></i>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    <button class="password-toggle" type="button" aria-label="Show password" data-target="password_confirmation">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="button-row">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Back to login</a>
                @endif
                <button class="auth-button" type="submit">Update Password</button>
            </div>
        </form>
    </section>
</main>

<script src="{{ asset('js/note-app/auth-simple.js') }}"></script>
</body>
</html>
