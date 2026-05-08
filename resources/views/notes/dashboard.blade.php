@php
    $notes = isset($notes) ? collect($notes) : collect();
    $labels = isset($labels) ? collect($labels) : collect();
    $stats = $stats ?? [
        'total' => $notes->count(),
        'shared' => $notes->where('is_shared', true)->count(),
        'pinned' => $notes->where('is_pinned', true)->count(),
        'locked' => $notes->where('is_locked', true)->count(),
    ];
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
            <p>Capture ideas, pin important notes, filter by labels, and keep shared work easy to find.</p>
        </div>
        <div class="stats">
            <div class="stat"><strong>{{ $stats['total'] }}</strong><span>Notes</span></div>
            <div class="stat"><strong>{{ $stats['shared'] }}</strong><span>Shared</span></div>
            <div class="stat"><strong>{{ $stats['pinned'] }}</strong><span>Pinned</span></div>
            <div class="stat"><strong>{{ $stats['locked'] }}</strong><span>Locked</span></div>
        </div>
    </section>

    <section class="dashboard-actions">
        <div class="quick-filters" aria-label="Note status filters">
            <button class="status-filter active" type="button" data-status-filter="all"><i class="bi bi-grid"></i> All</button>
            <button class="status-filter" type="button" data-status-filter="pinned"><i class="bi bi-pin-angle"></i> Pinned</button>
            <button class="status-filter" type="button" data-status-filter="shared"><i class="bi bi-people"></i> Shared</button>
            <button class="status-filter" type="button" data-status-filter="locked"><i class="bi bi-lock"></i> Locked</button>
        </div>
        <a class="btn-primary" href="{{ $createUrl }}"><i class="bi bi-plus-lg"></i> New note</a>
    </section>

    <section class="toolbar">
        <div class="search">
            <i class="bi bi-search"></i>
            <input data-note-search type="search" placeholder="Search title or content..." autocomplete="off">
        </div>
        <select class="filter-select" data-label-select>
            <option value="all">All labels</option>
            @foreach ($labels as $label)
                <option value="{{ $label->id }}">{{ $label->name }}</option>
            @endforeach
        </select>
        <button class="icon-btn active" type="button" data-view="grid" aria-label="Grid view"><i class="bi bi-grid-3x3-gap"></i></button>
        <button class="icon-btn" type="button" data-view="list" aria-label="List view"><i class="bi bi-list-ul"></i></button>
    </section>

    @if (auth()->user() && method_exists(auth()->user(), 'hasVerifiedEmail') && ! auth()->user()->hasVerifiedEmail())
        <div class="notice notice-warning" style="margin-bottom: 16px;">
            <i class="bi bi-exclamation-circle"></i>
            <span>Your account is not verified. Check your email to activate it.</span>
        </div>
    @endif

    <section class="notes-grid" data-notes-grid>
        @forelse ($notes as $note)
            @php
                $noteLabels = collect($note->labels ?? []);
                $labelIds = $noteLabels->pluck('id')->implode(' ');
                $statuses = collect([
                    $note->is_pinned ? 'pinned' : null,
                    $note->is_shared ? 'shared' : null,
                    $note->is_locked ? 'locked' : null,
                ])->filter()->implode(' ');
                $editUrl = Route::has('notes.edit') ? route('notes.edit', $note->id) : '#';
                $deleteUrl = Route::has('notes.destroy') ? route('notes.destroy', $note->id) : '#';
            @endphp

            <article class="note-card {{ $note->color ?? '' }}" data-note-card data-labels="{{ $labelIds }}" data-status="{{ $statuses }}">
                <div class="note-head">
                    <div class="note-title">{{ $note->title }}</div>
                    <div class="note-icons">
                        @if ($note->is_pinned)<i class="bi bi-pin-angle-fill" title="Pinned"></i>@endif
                        @if ($note->is_locked)<i class="bi bi-lock-fill" title="Locked"></i>@endif
                        @if ($note->is_shared)<i class="bi bi-people-fill" title="Shared"></i>@endif
                    </div>
                </div>

                <div class="chips">
                    @if ($note->is_pinned)<span class="chip"><i class="bi bi-pin-angle-fill"></i> Pinned</span>@endif
                    @if ($note->is_shared)<span class="chip"><i class="bi bi-people-fill"></i> Shared</span>@endif
                    @if ($note->is_locked)<span class="chip"><i class="bi bi-lock-fill"></i> Locked</span>@endif
                    @forelse ($noteLabels as $label)
                        <span class="chip">{{ $label->name }}</span>
                    @empty
                        <span class="chip">No label</span>
                    @endforelse
                </div>

                <p>{{ \Illuminate\Support\Str::limit($note->content, 130) }}</p>

                <div class="note-footer">
                    <span>Edited {{ optional($note->updated_at)->diffForHumans() ?? 'recently' }}</span>
                    <span class="note-actions">
            <a class="mini-btn" href="{{ $editUrl }}" aria-label="Edit note"><i class="bi bi-pencil"></i></a>
            <form class="inline-form" method="POST" action="{{ $deleteUrl }}">
              @csrf
                @method('DELETE')
              <button class="mini-btn" type="submit" aria-label="Delete note"><i class="bi bi-trash"></i></button>
            </form>
          </span>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h3>No notes yet</h3>
                <p>Create your first note to start organizing your ideas.</p>
                <a class="btn-primary" href="{{ $createUrl }}" style="margin-top: 18px;"><i class="bi bi-plus-lg"></i> New note</a>
            </div>
        @endforelse
    </section>

    <div class="empty-state is-hidden" data-empty-state style="margin-top: 16px;">
        <h3>No notes found</h3>
        <p>Try another keyword or clear the selected filters.</p>
    </div>
@endsection
