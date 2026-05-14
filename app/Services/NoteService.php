<?php

namespace App\Services;

use App\Contracts\Repositories\INoteRepository;
use App\Models\Note;
use App\Models\NoteTag;

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
    ): Note {
        // 1. khoi tao doi tuong
        $note = Note::make(
            title: $title,
            userId: $userId,
            content: $content,
            password: $password,
        );

        // 2. luu db
        $this->noteRepository->save($note);

        $this->syncTags(
            note: $note,
            userId: $userId,
            tags: $tags
        );

        return $note;
    }

    public function updateNote(
        int $noteId,
        string $title,
        ?string $content,
        ?string $password,
        array $tags = []
    ): Note {
        $note = $this->noteRepository->findById($noteId);
        $note->title = $title;
        $note->content = $content;
        $note->password = $password;

        $this->noteRepository->save($note);

        $this->syncTags(
            note: $note,
            userId: $note->created_by,
            tags: $tags
        );

        return $note;
    }

    public function deleteNote(
        int $noteId,
        int $userId
    ): bool {
        $note = $this->noteRepository
            ->findUserNoteById(
                noteId: $noteId,
                userId: $userId
            );

        return $this->noteRepository->delete($note);
    }

    protected function syncTags(
        Note $note,
        int $userId,
        array $tags = []
    ): void {
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tagName = trim($tagName);

            if ($tagName === '') {
                continue;
            }

            $tag = NoteTag::query()
                ->firstOrCreate([
                    'name' => $tagName,
                    'created_by' => $userId
                ]);

            $tagIds[] = $tag->getKey();
        }

        $note->tags()->sync($tagIds); // cập nhật bảng pivot
    }
}
