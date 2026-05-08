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
                    <label for="email">Recipient email</label>
                    <div class="input-wrap"><i class="bi bi-envelope"></i><input id="email" name="email" type="email" placeholder="teammate@tdtu.edu.vn" required></div>
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
                @forelse (($shares ?? []) as $share)
                    <div class="nav-link">
                        <span><i class="bi bi-person"></i> {{ optional($share->recipient)->email }}</span>
                        <span class="count">{{ $share->permission }}</span>
                    </div>
                @empty
                    <p class="muted">This note has not been shared yet.</p>
                @endforelse
            </div>
        </aside>
    </section>
@endsection
