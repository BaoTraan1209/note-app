@extends('layouts.app')

@section('title', 'Shared notes - NoteNest')
@section('eyebrow', 'Workspace')
@section('page_title', 'Shared with me')

@section('content')
    <section class="dashboard-actions">
        <div class="title-block">
            <h2 class="panel-title">Notes shared with you</h2>
        </div>
    </section>

    <section class="notes-grid list-view">
        @forelse ($notes as $note)
            @php
                $shareUser = $note->shareUsers->first();
                $permission = optional($shareUser?->pivot)->permission ?? 'read';
                $owner = $note->users;
                $sharedAt = optional($shareUser?->pivot)->created_at;
                $sharedSearchText = collect([
                    $note->title,
                    $note->password ? '' : strip_tags($note->content ?? ''),
                    optional($owner)->email,
                    $permission,
                ])->filter()->implode(' ');
            @endphp
            <article class="note-card shared-card"
                     data-note-card
                     data-open-url="{{ route('notes.show', $note->id) }}"
                     data-search-text="{{ e($sharedSearchText) }}"
                     data-status="shared {{ $permission === 'edit' ? 'editable' : 'readonly' }}">
                <div class="note-head">
                    <strong class="note-title">{{ $note->title }}</strong>
                    <div class="note-icons">
                        <i class="bi bi-people-fill" title="Shared"></i>
                        @if ($note->password)
                            <i class="bi bi-lock-fill" title="Locked"></i>
                        @endif
                    </div>
                </div>
                <div class="chips">
                    <span class="chip">{{ $permission === 'edit' ? 'Can edit' : 'Read only' }}</span>
                    <span class="chip">From {{ optional($owner)->email }}</span>
                    @if ($sharedAt)
                        <span class="chip">{{ $sharedAt->format('M d, Y H:i') }}</span>
                    @endif
                </div>
                @if ($note->password)
                    <p class="locked-preview"><i class="bi bi-lock-fill"></i> This shared note is protected. Enter password to view the content.</p>
                @else
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($note->content ?? ''), 180) }}</p>
                @endif
                <div class="note-footer">
                    <span>Shared {{ $sharedAt ? $sharedAt->diffForHumans() : 'recently' }}</span>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h3>No shared notes yet</h3>
                <p>When another registered user shares a note with you, it will appear here.</p>
            </div>
        @endforelse
    </section>
@endsection
