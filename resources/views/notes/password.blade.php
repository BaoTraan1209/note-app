@extends('layouts.app')

@section('title', 'Note password - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'Note password')

@section('content')
    <section class="auth-card compact">
        <div class="auth-head">
            <div class="brand"><span class="brand-mark"><i class="bi bi-lock"></i></span><span>NoteNest</span></div>
            <span class="badge"><i class="bi bi-shield-check"></i> Protected note</span>
        </div>

        <div class="title-block">
            <h2>{{ ($mode ?? 'manage') === 'unlock' ? 'Unlock protected note' : ($note->password ? 'Change note password' : 'Lock this note') }}</h2>
            <p class="muted">Each protected note uses its own password, separate from the account password.</p>
        </div>

        @if (($mode ?? 'manage') === 'unlock')
            <form class="auth-form" method="POST" action="{{ route('notes.password.unlock', $note->id) }}" data-loading-form>
                @csrf
                <div class="field">
                    <label for="current_password">Note password</label>
                    <div class="input-wrap"><i class="bi bi-lock"></i><input id="current_password" name="current_password" type="password" required><button class="password-toggle" type="button" data-password-toggle data-target="current_password"><i class="bi bi-eye"></i></button></div>
                </div>
                <button class="btn-primary" type="submit"><i class="bi bi-unlock"></i> Unlock note</button>
            </form>
        @else
            <form class="auth-form" method="POST" action="{{ route('notes.password.update', $note->id) }}" data-loading-form>
                @csrf
                @if ($note->password)
                    <div class="field">
                        <label for="current_password">Current note password</label>
                        <div class="input-wrap"><i class="bi bi-lock"></i><input id="current_password" name="current_password" type="password" required><button class="password-toggle" type="button" data-password-toggle data-target="current_password"><i class="bi bi-eye"></i></button></div>
                    </div>
                @endif
                <div class="field">
                    <label for="password">New note password</label>
                    <div class="input-wrap"><i class="bi bi-key"></i><input id="password" name="password" type="password" required><button class="password-toggle" type="button" data-password-toggle data-target="password"><i class="bi bi-eye"></i></button></div>
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="input-wrap"><i class="bi bi-shield-lock"></i><input id="password_confirmation" name="password_confirmation" type="password" required><button class="password-toggle" type="button" data-password-toggle data-target="password_confirmation"><i class="bi bi-eye"></i></button></div>
                </div>
                <button class="btn-primary" type="submit"><i class="bi bi-check-lg"></i> Save password</button>
            </form>

            @if ($note->password)
                <form class="auth-form danger-form" method="POST" action="{{ route('notes.password.destroy', $note->id) }}" data-confirm="Disable password protection for this note?">
                    @csrf
                    @method('DELETE')
                    <div class="field">
                        <label for="disable_current_password">Current password confirmation</label>
                        <div class="input-wrap"><i class="bi bi-shield-x"></i><input id="disable_current_password" name="current_password" type="password" required></div>
                    </div>
                    <button class="btn-secondary" type="submit"><i class="bi bi-unlock"></i> Disable protection</button>
                </form>
            @endif
        @endif
    </section>
@endsection
