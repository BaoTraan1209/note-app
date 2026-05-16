@php
    use Illuminate\Support\Facades\Route;
    $noteTags = collect($noteTags ?? []);
    $keyword = $keyword ?? request('keyword');
    $defaultView = auth()->user()?->preference('default_view', 'grid');
@endphp

@extends('layouts.app')

@section('title', 'Notes - NoteNest')
@section('eyebrow', 'Workspace')
@section('page_title', 'All notes')

@section('content')
    <section class="dashboard-actions">
        <div class="quick-filters">
            <button class="status-filter active" type="button" data-status-filter="all"><i class="bi bi-grid"></i> All
            </button>
            <button class="status-filter" type="button" data-status-filter="pinned"><i class="bi bi-pin-angle"></i>
                Pinned
            </button>
            <button class="status-filter" type="button" data-status-filter="locked"><i class="bi bi-lock"></i> Locked
            </button>
        </div>
        <a class="btn-primary" href="{{ Route::has('notes.create') ? route('notes.create') : '#' }}"><i
                class="bi bi-plus-lg"></i> New note</a>
    </section>

    <section class="toolbar">
        <form class="search" method="GET" action="{{ Route::has('notes.index') ? route('notes.index') : '#' }}">
            <i class="bi bi-search"></i>
            <input data-note-search name="keyword" value="{{ $keyword }}" type="search"
                   placeholder="Search title or content..." autocomplete="off">
        </form>
        <select class="filter-select" data-label-select name="labelId">
            <option value="all">All tags</option>
            @foreach ($noteTags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <button class="icon-btn {{ $defaultView === 'grid' ? 'active' : '' }}" type="button" data-view="grid" aria-label="Grid view"><i
                class="bi bi-grid-3x3-gap"></i></button>
        <button class="icon-btn {{ $defaultView === 'list' ? 'active' : '' }}" type="button" data-view="list" aria-label="List view"><i class="bi bi-list-ul"></i>
        </button>
    </section>

    <section class="notes-grid {{ $defaultView === 'list' ? 'list-view' : '' }}" data-notes-grid>
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
