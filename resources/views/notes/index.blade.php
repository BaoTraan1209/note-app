@php
    $notes = isset($notes) ? collect($notes) : collect();
    $labels = isset($labels) ? collect($labels) : collect();
    $keyword = $keyword ?? request('keyword');
@endphp

@extends('layouts.app')

@section('title', 'Notes - NoteNest')
@section('eyebrow', 'Workspace')
@section('page_title', 'All notes')

@section('content')
    <section class="dashboard-actions">
        <div class="quick-filters">
            <button class="status-filter active" type="button" data-status-filter="all"><i class="bi bi-grid"></i> All</button>
            <button class="status-filter" type="button" data-status-filter="pinned"><i class="bi bi-pin-angle"></i> Pinned</button>
            <button class="status-filter" type="button" data-status-filter="locked"><i class="bi bi-lock"></i> Locked</button>
        </div>
        <a class="btn-primary" href="{{ Route::has('notes.store-view') ? route('notes.store-view') : '#' }}"><i class="bi bi-plus-lg"></i> New note</a>
    </section>

    <section class="toolbar">
        <form class="search" method="GET" action="{{ Route::has('notes') ? route('notes') : '#' }}">
            <i class="bi bi-search"></i>
            <input data-note-search name="keyword" value="{{ $keyword }}" type="search" placeholder="Search title or content..." autocomplete="off">
        </form>
        <select class="filter-select" data-label-select name="labelId">
            <option value="all">All labels</option>
            @foreach ($labels as $label)
                <option value="{{ $label->id }}">{{ $label->name }}</option>
            @endforeach
        </select>
        <button class="icon-btn active" type="button" data-view="grid" aria-label="Grid view"><i class="bi bi-grid-3x3-gap"></i></button>
        <button class="icon-btn" type="button" data-view="list" aria-label="List view"><i class="bi bi-list-ul"></i></button>
    </section>

    <section class="notes-grid" data-notes-grid>
        @forelse ($notes as $note)
            @php
                $noteLabels = collect($note->labels ?? []);
                $labelIds = $noteLabels->pluck('id')->implode(' ');
                $statuses = collect([
                    $note->pinned ? 'pinned' : null,
                    $note->password ? 'locked' : null,
                ])->filter()->implode(' ');
                $showUrl = Route::has('notes.show') ? route('notes.show', $note->id) : '#';
                $editUrl = Route::has('notes.edit') ? route('notes.edit', $note->id) : '#';
                $deleteUrl = Route::has('notes.destroy') ? route('notes.destroy', $note->id) : '#';
            @endphp

            <article class="note-card {{ $note->color ?? '' }}" data-note-card data-labels="{{ $labelIds }}" data-status="{{ $statuses }}">
                <div class="note-head">
                    <a class="note-title" href="{{ $showUrl }}">{{ $note->title }}</a>
                    <div class="note-icons">
                        @if ($note->pinned)<i class="bi bi-pin-angle-fill" title="Pinned"></i>@endif
                        @if ($note->password)<i class="bi bi-lock-fill" title="Locked"></i>@endif
                    </div>
                </div>
                <div class="chips">
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
                        <a class="mini-btn" href="{{ $showUrl }}" aria-label="Open note"><i class="bi bi-eye"></i></a>
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
                <a class="btn-primary" href="{{ Route::has('notes.store-view') ? route('notes.store-view') : '#' }}" style="margin-top: 18px;"><i class="bi bi-plus-lg"></i> New note</a>
            </div>
        @endforelse
    </section>

    <div class="empty-state is-hidden" data-empty-state style="margin-top: 16px;">
        <h3>No notes found</h3>
        <p>Try another keyword or clear the selected filters.</p>
    </div>
@endsection
