@extends('layouts.guest')

@section('title', 'Confirm Password - NoteNest')

@section('content')
    <main class="guest-shell" style="grid-template-columns: 1fr;">
        <section class="auth-card compact">
            <div class="auth-head"><div class="brand"><span class="brand-mark"><i class="bi bi-shield-lock"></i></span><span>NoteNest</span></div></div>
            <div class="title-block"><h2>Confirm password</h2><p class="muted">This is a secure area. Please confirm your password to continue.</p></div>
            @if ($errors->any())<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i><span>{{ $errors->first() }}</span></div>@endif
            <form class="auth-form" method="POST" action="{{ route('password.confirm') }}" data-loading-form>
                @csrf
                <div class="field"><label for="password">Password</label><div class="input-wrap"><i class="bi bi-lock"></i><input id="password" name="password" type="password" required autofocus><button class="password-toggle" type="button" data-password-toggle data-target="password"><i class="bi bi-eye"></i></button></div></div>
                <div class="form-row"><a href="{{ url()->previous() }}">Back</a><button class="btn-primary" type="submit">Confirm</button></div>
            </form>
        </section>
    </main>
@endsection
