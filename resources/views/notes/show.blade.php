@php
    $noteLabels = collect($note->labels ?? []);
    $editUrl = Route::has('notes.edit') ? route('notes.edit', $note->id) : '#';
    $deleteUrl = Route::has('notes.destroy') ? route('notes.destroy', $note->id) : '#';
@endphp

@extends('layouts.app')

@section('title', $note->title . ' - NoteNest')
@section('eyebrow', 'Notes')
@section('page_title', 'Note details')

@section('content')
    <section class="show-panel {{ $note->color ?? '' }}">
        <div class="meta-row">
            @if ($note->is_pinned)<span class="chip"><i class="bi bi-pin-angle-fill"></i> Pinned</span>@endif
            @if ($note->is_shared)<span class="chip"><i class="bi bi-people-fill"></i> Shared</span>@endif
            @if ($note->is_locked)<span class="chip"><i class="bi bi-lock-fill"></i> Locked</span>@endif
            <span>Updated {{ optional($note->updated_at)->diffForHumans() ?? 'recently' }}</span>
        </div>

        <h2 class="show-title">{{ $note->title }}</h2>

        <div class="chips">
            @forelse ($noteLabels as $label)
                <span class="chip">{{ $label->name }}</span>
            @empty
                <span class="chip">No label</span>
            @endforelse
        </div>

        <div class="show-content">{{ $note->content }}</div>

        <div class="action-row">
            <a class="btn-primary" href="{{ $editUrl }}"><i class="bi bi-pencil"></i> Edit note</a>
            <a class="btn-secondary" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}"><i class="bi bi-arrow-left"></i> Back</a>
            <form class="inline-form" method="POST" action="{{ $deleteUrl }}">
                @csrf
                @method('DELETE')
                <button class="btn-secondary" type="submit"><i class="bi bi-trash"></i> Delete</button>
            </form>
        </div>
    </section>
@endsection
