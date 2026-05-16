@php
    $user = auth()->user();
    $initials = $user?->initials() ?? 'NA';
    $themeClass = $user?->preference('theme') === 'dark' ? 'dark-theme' : '';
    $avatarUrl = $user?->avatar ? asset('storage/'.$user->avatar) : null;
@endphp

    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ $user?->getKey() }}">
    <title>@yield('title', config('app.name', 'NoteNest'))</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="{{ $themeClass }}">
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand brand-link" href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}" aria-label="Go to dashboard">
            <span class="brand-mark"><i class="bi bi-journal-richtext"></i></span>
            <span>NoteNest</span>
        </a>

        <a class="btn-primary create-btn" href="{{ Route::has('notes.create') ? route('notes.create') : '#' }}">
            <i class="bi bi-plus-lg"></i> New note
        </a>

        <nav class="nav-group">
            <div class="nav-title">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}"><span><i class="bi bi-grid"></i> Dashboard</span></a>
            <a class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}" href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}"><span><i class="bi bi-journal-text"></i> Notes</span></a>
            <a class="nav-link {{ request()->routeIs('shared.*') ? 'active' : '' }}" href="{{ Route::has('shared.index') ? route('shared.index') : '#' }}"><span><i class="bi bi-people"></i> Shared</span></a>
        </nav>

        <nav class="nav-group">
            <div class="nav-title">Account</div>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"><span><i class="bi bi-person"></i> Profile</span></a>
            <a class="nav-link {{ request()->routeIs('preferences.*') ? 'active' : '' }}" href="{{ Route::has('preferences.edit') ? route('preferences.edit') : '#' }}"><span><i class="bi bi-sliders"></i> Preferences</span></a>
        </nav>

        <div class="sidebar-user">
            <div class="avatar">
                @if ($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="{{ $user->name }} avatar">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div>
                <strong>{{ $user->display_name ?: $user->name ?? 'Guest User' }}</strong>
                <small>{{ $user->email ?? 'guest@example.com' }}</small>
            </div>
        </div>
    </aside>

    <div class="app-content">
        <header class="topbar">
            <button class="icon-btn sidebar-toggle" type="button" data-sidebar-toggle aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
            <div class="page-heading">
                <span>@yield('eyebrow', 'Workspace')</span>
                <h1>@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="topbar-actions">
                <div class="user-menu">
                    <button class="user-button" type="button" data-user-menu>
                        <span class="avatar small">
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $user->name }} avatar">
                            @else
                                {{ $initials }}
                            @endif
                        </span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="user-dropdown" data-user-dropdown>
                        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"><i class="bi bi-person"></i> Profile</a>
                        <a href="{{ Route::has('preferences.edit') ? route('preferences.edit') : '#' }}"><i class="bi bi-sliders"></i> Preferences</a>
                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"><i class="bi bi-box-arrow-right"></i> Log out</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        @if (session('status'))
            <div class="alert alert-success"><i class="bi bi-check-circle"></i><span>{{ session('status') }}</span></div>
        @endif

        @if (! request()->routeIs('dashboard') && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="notice notice-warning">
                <i class="bi bi-envelope-exclamation"></i>
                <span>Your account is not verified. Please check your email for the activation link.</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i><span>{{ $errors->first() }}</span></div>
        @endif

        <main class="page-body">
            @yield('content')
        </main>
    </div>
</div>

<nav class="mobile-nav">
    <a href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}"><i class="bi bi-grid"></i><span>Home</span></a>
    <a href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}"><i class="bi bi-journal-text"></i><span>Notes</span></a>
    <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"><i class="bi bi-person"></i><span>Account</span></a>
</nav>

<div class="confirm-modal" data-confirm-modal aria-hidden="true">
    <div class="confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
        <div class="confirm-icon"><i class="bi bi-exclamation-triangle"></i></div>
        <div>
            <h2 id="confirm-title">Are you sure?</h2>
            <p data-confirm-message>This action needs your confirmation.</p>
        </div>
        <div class="confirm-actions">
            <button class="btn-secondary" type="button" data-confirm-cancel>Cancel</button>
            <button class="btn-danger" type="button" data-confirm-accept>Yes, delete</button>
        </div>
    </div>
</div>

</body>
</html>
