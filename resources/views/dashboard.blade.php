@extends('layouts.app')

@section('title', 'Dashboard - NoteNest')
@section('eyebrow', 'Workspace')
@section('page_title', 'Dashboard')

@section('content')
    <section class="hero">
        <div>
            <h2>Your notes, organized.</h2>
            <p>Open your notes workspace, review pinned notes, and continue where you left off.</p>
        </div>
        <div class="stats">
            <div class="stat"><strong>{{ $stats['total'] ?? 0 }}</strong><span>Notes</span></div>
            <div class="stat"><strong>{{ $stats['shared'] ?? 0 }}</strong><span>Shared</span></div>
            <div class="stat"><strong>{{ $stats['pinned'] ?? 0 }}</strong><span>Pinned</span></div>
            <div class="stat"><strong>{{ $stats['locked'] ?? 0 }}</strong><span>Locked</span></div>
        </div>
    </section>

    <section class="dashboard-actions">
        <div class="quick-filters">
            <a class="status-filter active" href="{{ Route::has('notes.index') ? route('notes.index') : '#' }}"><i class="bi bi-journal-text"></i> All notes</a>
            <a class="status-filter" href="{{ Route::has('shared.index') ? route('shared.index') : '#' }}"><i class="bi bi-people"></i> Shared</a>
        </div>
        <a class="btn-primary" href="{{ Route::has('notes.create') ? route('notes.create') : '#' }}"><i class="bi bi-plus-lg"></i> New note</a>
    </section>
@endsection
