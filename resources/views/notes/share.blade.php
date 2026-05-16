@extends('layouts.app')

@section('title', 'Share note - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'Share note')

@section('content')
    <section class="note-form-layout">
        <div class="editor-panel">
            <div class="title-block">
                <h2 class="panel-title">Share "{{ $note->title }}"</h2>
                <p class="muted">Invite registered users by email and choose whether they can view or edit this note.</p>
            </div>

            <form class="auth-form" method="POST" action="{{ Route::has('notes.share.store') ? route('notes.share.store', $note->id) : '#' }}" data-loading-form>
                @csrf
                <div class="field">
                    <label for="emails">Recipient emails</label>
                    <div class="input-wrap"><i class="bi bi-envelope"></i><input id="emails" name="emails" type="text" placeholder="teammate@tdtu.edu.vn, example@gmail.com" required></div>
                    <p class="muted">Only registered users can receive shared notes. Separate multiple emails with commas.</p>
                </div>
                <div class="field">
                    <label for="permission">Permission</label>
                    <select class="filter-select" id="permission" name="permission">
                        <option value="read">Read only</option>
                        <option value="edit">Can edit</option>
                    </select>
                </div>
                <button class="btn-primary" type="submit"><i class="bi bi-send"></i> Send invite</button>
            </form>
        </div>

        <aside class="settings-panel">
            <div class="settings-block">
                <div class="settings-title">Current access</div>
                @forelse (($shareUsers ?? []) as $shareUser)
                    <div class="share-row">
                        <div class="share-person-info">
                            <strong><i class="bi bi-person"></i> {{ $shareUser->email }}</strong>
                            <small class="muted">Shared {{ optional($shareUser->pivot->created_at)->format('M d, Y H:i') }}</small>
                        </div>
                        <form class="share-permission-form" method="POST" action="{{ route('notes.share.update', [$note->id, $shareUser->pivot->id]) }}">
                            @csrf
                            @method('PATCH')
                            <select class="filter-select" name="permission" onchange="this.form.submit()">
                                <option value="read" {{ $shareUser->pivot->permission === 'read' ? 'selected' : '' }}>Read only</option>
                                <option value="edit" {{ $shareUser->pivot->permission === 'edit' ? 'selected' : '' }}>Can edit</option>
                            </select>
                        </form>
                        <form class="share-delete-form" method="POST" action="{{ route('notes.share.destroy', [$note->id, $shareUser->pivot->id]) }}" data-confirm="Revoke this user's access?">
                            @csrf
                            @method('DELETE')
                            <button class="mini-btn" type="submit" title="Revoke access"><i class="bi bi-x-lg"></i></button>
                        </form>
                    </div>
                @empty
                    <p class="muted">This note has not been shared yet.</p>
                @endforelse
            </div>
        </aside>
    </section>
@endsection

