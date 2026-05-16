@php
    use Illuminate\Support\Facades\Route;

    $noteTags = collect($note->tags ?? []);
    $tagIds = $noteTags->pluck('id')->implode(' ');

    $statuses = collect([
        $note->pinned_at ? 'pinned' : null,
        $note->password ? 'locked' : null,
        ($note->relationLoaded('shareUsers') && $note->shareUsers->isNotEmpty()) ? 'shared' : null,
    ])->filter()->implode(' ');

    $showUrl = Route::has('notes.show') ? route('notes.show', $note->id) : '#';
    $pinUrl = Route::has('notes.pin') ? route('notes.pin', $note->id) : '#';
    $deleteUrl = Route::has('notes.destroy') ? route('notes.destroy', $note->id) : '#';
    $searchText = collect([
        $note->title,
        $note->password ? '' : strip_tags($note->content ?? ''),
        $noteTags->pluck('name')->implode(' '),
    ])->filter()->implode(' ');
    $noteImages = $note->password ? collect() : collect($note->images ?? []);
@endphp

<article
    class="note-card"
    data-note-card
    data-open-url="{{ $showUrl }}"
    data-labels="{{ $tagIds }}"
    data-status="{{ $statuses }}"
    data-search-text="{{ e($searchText) }}"
>
    <div class="note-head">

        <strong class="note-title">
            {{ $note->title }}
        </strong>

        <div class="note-icons">

            <form class="inline-form" method="POST" action="{{ $pinUrl }}">
                @csrf
                @method('PATCH')
                <button class="mini-btn {{ $note->pinned_at ? 'active' : '' }}"
                        type="submit"
                        aria-label="{{ $note->pinned_at ? 'Unpin note' : 'Pin note' }}"
                        title="{{ $note->pinned_at ? 'Unpin note' : 'Pin note' }}">
                    <i class="bi {{ $note->pinned_at ? 'bi-pin-angle-fill' : 'bi-pin-angle' }}"></i>
                </button>
            </form>

            @if ($note->password)
                <i class="bi bi-lock-fill" title="Locked"></i>
            @endif

            @if ($note->relationLoaded('shareUsers') && $note->shareUsers->isNotEmpty())
                <i class="bi bi-people-fill" title="Shared"></i>
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

    @if ($note->password)
        <p class="locked-preview" data-card-preview>
            <i class="bi bi-lock-fill"></i>
            This note is password protected. Unlock it to view the content.
        </p>
    @else
        <p data-card-preview>
            {{ trim(strip_tags($note->content ?? 'No content yet.')) }}
        </p>
    @endif

    @if ($noteImages->isNotEmpty())
        <div class="note-image-strip" aria-label="Attached images">
            @foreach ($noteImages->take(3) as $image)
                <img src="{{ asset('storage/'.$image) }}" alt="">
            @endforeach
            @if ($noteImages->count() > 3)
                <span>+{{ $noteImages->count() - 3 }}</span>
            @endif
        </div>
    @endif

    <div class="note-footer">

        <span>
            Edited {{ optional($note->updated_at)->diffForHumans() ?? 'recently' }}
        </span>

        <span class="note-actions">
            <form class="inline-form note-card-action"
                  method="POST"
                  action="{{ $deleteUrl }}"
                  data-confirm="Delete this note?">

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

