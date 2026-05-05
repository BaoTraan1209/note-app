<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot password - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/auth-simple.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-envelope-paper"></i></span>
            <span>NoteNest</span>
        </div>

        <h1>Forgot password?</h1>
        <p class="subtitle">Enter your account email. The system will send a password reset link to your inbox.</p>

        @if (session('status'))
            <div class="status-box">
                <i class="bi bi-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-box">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>
                <span class="helper">If the email exists in the system, you will receive a password reset link.</span>
            </div>

            <div class="button-row">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Back to login</a>
                @endif
                <button class="auth-button" type="submit">Send Reset Link</button>
            </div>
        </form>
    </section>
</main>

<script src="{{ asset('js/note-app/auth-simple.js') }}"></script>
</body>
</html>
