<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quen mat khau - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth-simple.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-envelope-paper"></i></span>
            <span>NoteNest</span>
        </div>

        <h1>Quen mat khau?</h1>
        <p class="subtitle">Nhap email tai khoan. He thong se gui lien ket dat lai mat khau den hop thu cua ban.</p>

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
                <span class="helper">Neu email ton tai trong he thong, ban se nhan duoc huong dan dat lai mat khau.</span>
            </div>

            <div class="button-row">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Ve dang nhap</a>
                @endif
                <button class="auth-button" type="submit">Gui lien ket</button>
            </div>
        </form>
    </section>
</main>

<script src="{{ asset('js/auth-simple.js') }}"></script>
</body>
</html>
