@extends('layouts.guest')

@section('title', 'Reset Password - NoteNest')

@section('content')
    <main class="guest-shell" style="grid-template-columns: 1fr;">
        <section class="auth-card compact">
            <div class="auth-head"><div class="brand"><span class="brand-mark"><i class="bi bi-key"></i></span><span>NoteNest</span></div></div>
            <div class="title-block"><h2>Reset password</h2><p class="muted">Create a new password for your account.</p></div>
            @if ($errors->any())<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i><span>{{ $errors->first() }}</span></div>@endif
            <form class="auth-form" method="POST" action="{{ route('password.store') }}" data-loading-form>
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="field"><label for="email">Email</label><div class="input-wrap"><i class="bi bi-envelope"></i><input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus></div></div>
                <div class="field"><label for="password">New password</label><div class="input-wrap"><i class="bi bi-lock"></i><input id="password" name="password" type="password" required><button class="password-toggle" type="button" data-password-toggle data-target="password"><i class="bi bi-eye"></i></button></div></div>
                <div class="field"><label for="password_confirmation">Confirm password</label><div class="input-wrap"><i class="bi bi-shield-lock"></i><input id="password_confirmation" name="password_confirmation" type="password" required><button class="password-toggle" type="button" data-password-toggle data-target="password_confirmation"><i class="bi bi-eye"></i></button></div></div>
                <button class="btn-primary" type="submit">Update password</button>
            </form>
        </section>
    </main>
@endsection
