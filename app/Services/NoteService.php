<?php

namespace App\Services;

use App\Contracts\Repositories\INoteRepository;
use App\Models\Note;
use App\Models\NoteTag;
use Illuminate\Support\Carbon;

class NoteService
{
    public function __construct(
        protected INoteRepository $noteRepository,
    ) { }

    public function createNote(
        string $title,
        int $userId,
        ?string $content,
        ?string $password,
        ?array $tags,
        bool $isPinned = false,
        int $fontSize = 16,
    ): Note {
        $note = Note::make(
            title: $title,
            userId: $userId,
            content: $content,
            password: $password,
        );
        $note->pinned_at = $isPinned ? Carbon::now() : null;
        $note->font_size = $fontSize;

        $this->noteRepository->save($note);

        $this->syncTags(
            note: $note,
            userId: $userId,
            tags: $tags ?? []
        );

        return $note;
    }

    public function updateNote(
        int $noteId,
        string $title,
        ?string $content,
        ?string $password,
        array $tags = [],
        bool $isPinned = false,
        ?int $fontSize = null,
        ?int $userId = null
    ): Note {
        $note = $this->noteRepository->findById($noteId);
        $nextTagNames = $this->parseTagNames($tags);

        $note->title = $title;
        $note->content = $content;
        if ($password !== null && $password !== '') {
            $note->password = $password;
        }
        $note->pinned_at = $isPinned ? ($note->pinned_at ?: Carbon::now()) : null;
        $note->font_size = $fontSize ?? $note->font_size ?? 16;

        if ($note->isDirty()) {
            $this->noteRepository->save($note);
        }

        if (($userId === null || $userId === $note->created_by) && $this->tagNamesChanged($note, $nextTagNames)) {
            $this->renameInlineTagsWhenPossible($note, $tags);
            $this->syncTags(
                note: $note,
                userId: $note->created_by,
                tags: $tags
            );
        }

        return $note;
    }

    protected function tagNamesChanged(Note $note, array $nextTagNames): bool
    {
        $currentTagNames = $note->tags()
            ->where('created_by', $note->created_by)
            ->orderBy('note_tags.id')
            ->pluck('name')
            ->values()
            ->all();

        return $currentTagNames !== $nextTagNames;
    }

    public function togglePin(int $noteId, int $userId): Note
    {
        $note = $this->noteRepository->findUserNoteById(
            noteId: $noteId,
            userId: $userId
        );

        $note->pinned_at = $note->pinned_at ? null : Carbon::now();
        $this->noteRepository->save($note);

        return $note;
    }

    public function deleteNote(int $noteId, int $userId): bool
    {
        $note = $this->noteRepository->findUserNoteById(
            noteId: $noteId,
            userId: $userId
        );

        return $this->noteRepository->delete($note);
    }

    protected function renameInlineTagsWhenPossible(Note $note, array $tags): void
    {
        $currentTags = $note->tags()
            ->where('created_by', $note->created_by)
            ->orderBy('note_tags.id')
            ->get()
            ->values();
        $nextNames = $this->parseTagNames($tags);

        if ($currentTags->isEmpty() || $currentTags->count() !== count($nextNames)) {
            return;
        }

        foreach ($currentTags as $index => $tag) {
            $newName = $nextNames[$index] ?? null;

            if ($newName && $tag->name !== $newName) {
                $tag->update(['name' => $newName]);
            }
        }
    }

    protected function syncTags(Note $note, int $userId, array $tags = []): void
    {
        $tagIds = [];

        foreach ($this->parseTagNames($tags) as $tagName) {
            $tag = NoteTag::query()
                ->firstOrCreate([
                    'name' => $tagName,
                    'created_by' => $userId
                ]);

            $tagIds[] = $tag->getKey();
        }

        $note->tags()->sync($tagIds);
    }

    protected function parseTagNames(array $tags): array
    {
        $tagNames = [];

        foreach ($tags as $tagName) {
            foreach (preg_split('/,/', (string) $tagName) ?: [] as $name) {
                $name = trim($name);

                if ($name !== '') {
                    $tagNames[] = $name;
                }
            }
        }

        return array_values(array_unique($tagNames));
    }
}
