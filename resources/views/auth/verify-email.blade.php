@extends('layouts.guest')

@section('title', 'Verify Email - NoteNest')

@section('content')
    <main class="guest-shell" style="grid-template-columns: 1fr;">
        <section class="auth-card compact">
            <div class="auth-head"><div class="brand"><span class="brand-mark"><i class="bi bi-envelope-check"></i></span><span>NoteNest</span></div></div>
            <div class="title-block"><h2>Verify your email</h2><p class="muted">Please check your inbox and click the activation link to verify your account.</p></div>
            @if (session('status') == 'verification-link-sent')<div class="alert alert-success"><i class="bi bi-check-circle"></i><span>A new verification link has been sent.</span></div>@endif
            <form class="auth-form" method="POST" action="{{ route('verification.send') }}" data-loading-form>
                @csrf
                <button class="btn-primary" type="submit">Resend verification email</button>
            </form>
            @if (Route::has('logout'))
                <form class="auth-form" method="POST" action="{{ route('logout') }}" style="margin-top: 12px;">
                    @csrf
                    <button class="btn-secondary" type="submit">Log out</button>
                </form>
            @endif
        </section>
    </main>
@endsection
