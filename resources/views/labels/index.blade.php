@extends('layouts.app')

@section('title', 'Labels - NoteNest')
@section('eyebrow', 'Workspace')
@section('page_title', 'Labels')

@section('content')
    <section class="panel" style="padding: 24px;">
        <div class="title-block">
            <h2 class="panel-title">Manage labels</h2>
            <p class="muted">Create, rename, and remove labels without deleting notes.</p>
        </div>

        <form class="auth-form" method="POST" action="{{ Route::has('labels.store') ? route('labels.store') : '#' }}" style="margin-bottom: 18px;">
            @csrf
            <div class="field">
                <label for="name">New label</label>
                <div class="input-wrap"><i class="bi bi-tags"></i><input id="name" name="name" type="text" placeholder="Project"></div>
            </div>
            <button class="btn-primary" type="submit">Add label</button>
        </form>

        <div class="nav-group">
            @forelse (($labels ?? []) as $label)
                <div class="nav-link">
                    <span><i class="bi bi-circle-fill" style="color: {{ $label->color ?? '#47b78d' }}"></i> {{ $label->name }}</span>
                    <span class="count">{{ $label->notes_count ?? 0 }} notes</span>
                </div>
            @empty
                <p class="muted">No labels yet.</p>
            @endforelse
        </div>
    </section>
@endsection
