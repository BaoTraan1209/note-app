<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Register - NoteNest</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>
<body>
<main class="register-shell">
    <section class="register-card" aria-label="Register form">
        <div class="card-content">
            <div class="card-top">
                <div class="brand">
                    <span class="brand-mark"><i class="bi bi-journal-richtext"></i></span>
                    <span>NoteNest</span>
                </div>
                <span class="secure-badge"><i class="bi bi-envelope-check"></i> Send an email to activate</span>
            </div>

            <div class="title-block">
                <h2>Create new account</h2>
                <p class="subtitle">Just email, username and password. After registering, you will be logged in automatically</p>
            </div>

            @if ($errors->any())
                <div class="helper is-error">
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form id="registerForm" action="{{ route('register') }}" method="post">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope"></i>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                    </div>
                    <span class="helper">Using email can receive activation link.</span>
                </div>

                <div class="field">
                    <label for="name">Username</label>
                    <div class="input-wrap">
                        <i class="bi bi-person"></i>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock"></i>
                        <input id="password" name="password" type="password" autocomplete="new-password" required>
                        <button class="password-toggle" type="button" aria-label="Show password" data-target="password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength" data-level="1">
                        <div class="strength-bars"><span></span><span></span><span></span><span></span></div>
                        <span class="helper strength-text">Password strength: low</span>
                    </div>
                </div>

                <div class="field">
                    <label for="password_confirmation">Re-enter password</label>
                    <div class="input-wrap">
                        <i class="bi bi-shield-lock"></i>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                        <button class="password-toggle" type="button" aria-label="Show password" data-target="password_confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <span class="helper match-text">Re-enter the password to activate.</span>
                </div>

                <label class="terms">
                    <input type="checkbox" required>
                    <span>I agree to create a NoteNest account and receive an activation email at the registered address.</span>
                </label>

                <button class="register-button" type="submit">
                    <span class="button-text">Register</span>
                </button>
            </form>

            <p class="login-line">
                Have an account?
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Log in</a>
                @else
                    <a href="#">Log in</a>
                @endif
            </p>
        </div>
    </section>

    <section class="brand-panel" aria-label="Loi ich tai khoan">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-journal-text"></i></span>
            <span>NoteNest</span>
        </div>

        <div>
            <h1>Start organizing your notes.</h1>
            <p class="lead">Create notes, add labels, share securely, protect content, and customize your workspace.</p>
        </div>

        <div class="feature-list">
            <article class="feature-item">
                <span class="feature-icon"><i class="bi bi-magic"></i></span>
                <div>
                    <strong>Auto-save</strong>
                    <p>Your notes are saved automatically while you write.</p>
                </div>
            </article>

            <article class="feature-item">
                <span class="feature-icon"><i class="bi bi-tags"></i></span>
                <div>
                    <strong>Labels</strong>
                    <p>Organize and filter notes with one or more labels.</p>
                </div>
            </article>

            <article class="feature-item">
                <span class="feature-icon"><i class="bi bi-people"></i></span>
                <div>
                    <strong>Sharing</strong>
                    <p>Invite others to view or edit notes with custom permissions.</p>
                </div>
            </article>
        </div>
    </section>
</main>

<script src="{{ asset('js/note-app/register.js') }}"></script>
</body>
</html>
