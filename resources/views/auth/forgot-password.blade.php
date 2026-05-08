@extends('layouts.guest')

@section('title', 'Forgot Password - NoteNest')

@section('content')
    <main class="guest-shell" style="grid-template-columns: 1fr;">
        <section class="auth-card compact">
            <div class="auth-head">
                <div class="brand"><span class="brand-mark"><i class="bi bi-envelope-paper"></i></span><span>NoteNest</span></div>
            </div>
            <div class="title-block"><h2>Forgot password?</h2><p class="muted">Enter your email and we will send you a password reset link.</p></div>
            @if (session('status'))<div class="alert alert-success"><i class="bi bi-check-circle"></i><span>{{ session('status') }}</span></div>@endif
            @if ($errors->any())<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i><span>{{ $errors->first() }}</span></div>@endif
            <form class="auth-form" method="POST" action="{{ route('password.email') }}" data-loading-form>
                @csrf
                <div class="field"><label for="email">Email</label><div class="input-wrap"><i class="bi bi-envelope"></i><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus></div></div>
                <div class="form-row">@if (Route::has('login'))<a href="{{ route('login') }}">Back to login</a>@endif<button class="btn-primary" type="submit">Send reset link</button></div>
            </form>
        </section>
    </main>
@endsection
