@extends('layouts.app')

@section('title', 'Offline - NoteNest')
@section('eyebrow', 'PWA')
@section('page_title', 'Offline mode')

@section('content')
    <section class="auth-card compact">
        <div class="auth-head">
            <div class="brand"><span class="brand-mark"><i class="bi bi-cloud-slash"></i></span><span>NoteNest</span></div>
        </div>
        <div class="title-block">
            <h2>You are offline</h2>
            <p class="muted">Cached notes can still be viewed. New changes will sync when the connection is restored.</p>
        </div>
        <div class="notice notice-warning">
            <i class="bi bi-wifi-off"></i>
            <span>Your edits are stored locally and will be synchronized when the connection returns.</span>
        </div>
        <a class="btn-primary" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}" style="margin-top: 18px;"><i class="bi bi-arrow-left"></i> Back to dashboard</a>
    </section>
@endsection
