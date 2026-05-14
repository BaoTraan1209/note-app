@php
    use Illuminate\Support\Facades\Route;

    $noteTags = collect($note->tags ?? []);
    $tagIds = $noteTags->pluck('id')->implode(' ');

    $statuses = collect([
        $note->pinned_at ? 'pinned' : null,
        $note->password ? 'locked' : null,
    ])->filter()->implode(' ');

    $showUrl = Route::has('notes.show') ? route('notes.show', $note->id) : '#';
    $editUrl = Route::has('notes.edit') ? route('notes.edit', $note->id) : '#';
    $deleteUrl = Route::has('notes.destroy') ? route('notes.destroy', $note->id) : '#';
@endphp

<article
    class="note-card {{ $note->color ?? '' }}"
    data-note-card
    data-labels="{{ $tagIds }}"
    data-status="{{ $statuses }}"
>

    <div class="note-head">

        <a class="note-title" href="{{ $showUrl }}">
            {{ $note->title }}
        </a>

        <div class="note-icons">

            @if ($note->pinned_at)
                <i class="bi bi-pin-angle-fill" title="Pinned"></i>
            @endif

            @if ($note->password)
                <i class="bi bi-lock-fill" title="Locked"></i>
            @endif

        </div>

    </div>

    <div class="chips">

        @forelse ($noteTags as $tag)

            <span class="chip">
                {{ $tag->name }}
            </span>

        @empty

            <span class="chip">
                No tag
            </span>

        @endforelse

    </div>

    <p>
        {{ \Illuminate\Support\Str::limit(strip_tags($note->content), 130) }}
    </p>

    <div class="note-footer">

        <span>
            Edited {{ optional($note->updated_at)->diffForHumans() ?? 'recently' }}
        </span>

        <span class="note-actions">

            <a class="mini-btn"
               href="{{ $showUrl }}"
               aria-label="Open note">

                <i class="bi bi-eye"></i>

            </a>

            <a class="mini-btn"
               href="{{ $editUrl }}"
               aria-label="Edit note">

                <i class="bi bi-pencil"></i>

            </a>

            <form class="inline-form"
                  method="POST"
                  action="{{ $deleteUrl }}">

                @csrf
                @method('DELETE')

                <button class="mini-btn"
                        type="submit"
                        aria-label="Delete note">

                    <i class="bi bi-trash"></i>

                </button>
            </form>
        </span>
    </div>
</article>
