@extends('layouts.app')

@section('title', 'Edit label - NoteNest')
@section('eyebrow', 'Labels')
@section('page_title', 'Edit label')

@section('content')
    <section class="panel" style="padding: 24px;">
        <div class="title-block">
            <h2 class="panel-title">Edit label</h2>
            <p class="muted">Renaming a label updates every note connected to it.</p>
        </div>

        <form class="auth-form" method="POST" action="{{ Route::has('labels.update') ? route('labels.update', $label->id) : '#' }}" data-loading-form>
            @csrf
            @method('PUT')
            <div class="field">
                <label for="name">Label name</label>
                <div class="input-wrap"><i class="bi bi-tags"></i><input id="name" name="name" type="text" value="{{ old('name', $label->name) }}" required autofocus></div>
            </div>
            <div class="field">
                <label for="color">Color</label>
                <div class="input-wrap"><i class="bi bi-palette"></i><input id="color" name="color" type="color" value="{{ old('color', $label->color ?? '#47b78d') }}" style="padding-left: 48px;"></div>
            </div>
            <div class="action-row">
                <button class="btn-primary" type="submit"><i class="bi bi-check-lg"></i> Save label</button>
                <a class="btn-secondary" href="{{ Route::has('labels.index') ? route('labels.index') : '#' }}"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </form>

        <form class="inline-form" method="POST" action="{{ Route::has('labels.destroy') ? route('labels.destroy', $label->id) : '#' }}" style="display:block;margin-top:16px;">
            @csrf
            @method('DELETE')
            <button class="btn-secondary" type="submit"><i class="bi bi-trash"></i> Delete label</button>
        </form>
    </section>
@endsection
