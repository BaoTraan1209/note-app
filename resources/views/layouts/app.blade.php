@php
    $user = auth()->user();
    $initials = strtoupper(substr($user->name ?? 'NA', 0, 2));
@endphp

    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NoteNest'))</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-journal-richtext"></i></span>
            <span>NoteNest</span>
        </div>

        <a class="btn-primary create-btn" href="{{ Route::has('notes.create') ? route('notes.create') : '#' }}">
            <i class="bi bi-plus-lg"></i> New note
        </a>

        <nav class="nav-group">
            <div class="nav-title">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}"><span><i class="bi bi-grid"></i> Dashboard</span></a>
            <a class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}" href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}"><span><i class="bi bi-journal-text"></i> Notes</span></a>
            <a class="nav-link {{ request()->routeIs('labels.*') ? 'active' : '' }}" href="{{ Route::has('labels.index') ? route('labels.index') : '#' }}"><span><i class="bi bi-tags"></i> Labels</span></a>
            <a class="nav-link {{ request()->routeIs('shared.*') ? 'active' : '' }}" href="{{ Route::has('shared.index') ? route('shared.index') : '#' }}"><span><i class="bi bi-people"></i> Shared</span></a>
        </nav>

        <nav class="nav-group">
            <div class="nav-title">Account</div>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"><span><i class="bi bi-person"></i> Profile</span></a>
            <a class="nav-link {{ request()->routeIs('preferences.*') ? 'active' : '' }}" href="{{ Route::has('preferences.edit') ? route('preferences.edit') : '#' }}"><span><i class="bi bi-sliders"></i> Preferences</span></a>
        </nav>

        <div class="sidebar-user">
            <div class="avatar">{{ $initials }}</div>
            <div>
                <strong>{{ $user->name ?? 'Guest User' }}</strong>
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
                <form class="global-search" action="{{ Route::has('notes.index') ? route('notes.index') : '#' }}" method="GET">
                    <i class="bi bi-search"></i>
                    <input name="q" type="search" value="{{ request('q') }}" placeholder="Search notes...">
                </form>

                <div class="user-menu">
                    <button class="user-button" type="button" data-user-menu>
                        <span class="avatar small">{{ $initials }}</span>
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
    <a href="{{ Route::has('labels.index') ? route('labels.index') : '#' }}"><i class="bi bi-tags"></i><span>Labels</span></a>
    <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"><i class="bi bi-person"></i><span>Account</span></a>
</nav>

{{--<script src="{{ asset('resources/js/pages/app.js') }}"></script>--}}
</body>
</html>
