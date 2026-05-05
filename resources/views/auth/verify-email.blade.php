<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/auth-simple.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-envelope-check"></i></span>
            <span>NoteNest</span>
        </div>

        <h1>Verify Email</h1>
        <p class="subtitle">Thank you for registering. Please check your email and click the activation link to activate your account.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="status-box">
                <i class="bi bi-check-circle"></i>
                <span>The verification link has been sent to your email.</span>
            </div>
        @endif

        <div class="verify-actions">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="auth-button" type="submit">Resend Verification Email</button>
            </form>

            <form class="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="link-button" type="submit">Logout</button>
            </form>
        </div>

        <p class="footer-link">You can still use the features while your account is not verified, but notifications will continue to appear on the website.</p>
    </section>
</main>

<script src="{{ asset('js/note-app/auth-simple.js') }}"></script>
</body>
</html>
