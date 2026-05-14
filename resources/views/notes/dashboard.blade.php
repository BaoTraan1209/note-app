@php
    use Illuminate\Support\Facades\Route;
    $tags = $metrics['tags'] ?? [];
    $keyword = $keyword ?? request('keyword');
    $createUrl = Route::has('notes.create') ? route('notes.create') : '#';
@endphp

@extends('layouts.app')

@section('title', 'Dashboard - NoteNest')
@section('eyebrow', 'Workspace')
@section('page_title', 'Dashboard')

@section('content')
    <section class="hero">
        <div>
            <h2>Your notes, organized.</h2>
            <p>Capture ideas, pin important notes, filter by tags, and keep shared work easy to find.</p>
        </div>
        <div class="stats">
            <div class="stat"><strong>{{ $metrics['total'] }}</strong><span>Notes</span></div>
            {{--            <div class="stat"><strong>{{ $stats['shared'] }}</strong><span>Shared</span></div>--}}
            <div class="stat"><strong>{{ $metrics['pinned'] }}</strong><span>Pinned</span></div>
            <div class="stat"><strong>{{ $metrics['locked'] }}</strong><span>Locked</span></div>
        </div>
    </section>

    <section class="dashboard-actions">
        <div class="quick-filters" aria-label="Note status filters">
            <button class="status-filter active" type="button" data-status-filter="all"><i class="bi bi-grid"></i> All
            </button>
            <button class="status-filter" type="button" data-status-filter="pinned"><i class="bi bi-pin-angle"></i>
                Pinned
            </button>
            {{--            <button class="status-filter" type="button" data-status-filter="shared"><i class="bi bi-people"></i> Shared</button>--}}
            <button class="status-filter" type="button" data-status-filter="locked"><i class="bi bi-lock"></i> Locked
            </button>
        </div>
        <a class="btn-primary" href="{{ $createUrl }}"><i class="bi bi-plus-lg"></i> New note</a>
    </section>

    <section class="toolbar">
        <div class="search">
            <i class="bi bi-search"></i>
            <input data-note-search type="search" placeholder="Search title or content..." autocomplete="off">
        </div>
        <select class="filter-select" data-label-select>
            <option value="all">All tags</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
            @endforeach
        </select>
        <button class="icon-btn active" type="button" data-view="grid" aria-label="Grid view"><i
                class="bi bi-grid-3x3-gap"></i></button>
        <button class="icon-btn" type="button" data-view="list" aria-label="List view"><i class="bi bi-list-ul"></i>
        </button>
    </section>

    @if (auth()->user() && method_exists(auth()->user(), 'hasVerifiedEmail') && ! auth()->user()->hasVerifiedEmail())
        <div class="notice notice-warning" style="margin-bottom: 16px;">
            <i class="bi bi-exclamation-circle"></i>
            <span>Your account is not verified. Check your email to activate it.</span>
        </div>
    @endif

    <section class="notes-grid" data-notes-grid>
        @forelse ($notes as $note)
            @include('notes.partials.note-card', [
                'note' => $note
            ])
        @empty
            <div class="empty-state">
                <h3>No notes yet</h3>
            </div>
        @endforelse
    </section>

    <div class="empty-state is-hidden" data-empty-state style="margin-top: 16px;">
        <h3>No notes found</h3>
        <p>Try another keyword or clear the selected filters.</p>
    </div>
@endsection
