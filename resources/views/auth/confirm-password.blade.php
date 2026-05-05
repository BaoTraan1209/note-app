<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm password - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/auth-simple.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-shield-lock"></i></span>
            <span>NoteNest</span>
        </div>

        <h1>Confirm password</h1>
        <p class="subtitle">This is a secure area. Please re-enter your password to continue.</p>

        @if ($errors->any())
            <div class="alert-box">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
                    <button class="password-toggle" type="button" aria-label="Show password" data-target="password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="button-row">
                <a href="{{ url()->previous() }}">Back</a>
                <button class="auth-button" type="submit">Confirm</button>
            </div>
        </form>
    </section>
</main>

<script src="{{ asset('js/note-app/auth-simple.js') }}"></script>
</body>
</html>
