@extends('layouts.app')

@section('title', 'New label - NoteNest')
@section('eyebrow', 'Labels')
@section('page_title', 'New label')

@section('content')
    <section class="panel" style="padding: 24px;">
        <div class="title-block">
            <h2 class="panel-title">Create label</h2>
            <p class="muted">Labels help you filter notes by project, class, or personal context.</p>
        </div>

        <form class="auth-form" method="POST" action="{{ Route::has('labels.store') ? route('labels.store') : '#' }}" data-loading-form>
            @csrf
            <div class="field">
                <label for="name">Label name</label>
                <div class="input-wrap"><i class="bi bi-tags"></i><input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Project" required autofocus></div>
            </div>
            <div class="field">
                <label for="color">Color</label>
                <div class="input-wrap"><i class="bi bi-palette"></i><input id="color" name="color" type="color" value="{{ old('color', '#47b78d') }}" style="padding-left: 48px;"></div>
            </div>
            <div class="action-row">
                <button class="btn-primary" type="submit"><i class="bi bi-check-lg"></i> Create label</button>
                <a class="btn-secondary" href="{{ Route::has('labels.index') ? route('labels.index') : '#' }}"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </form>
    </section>
@endsection
