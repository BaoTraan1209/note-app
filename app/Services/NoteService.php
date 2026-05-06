<?php

namespace App\Services;

use App\Contracts\Repositories\INoteRepository;
use App\Models\Note;

class NoteService
{
    public function __construct(
        protected INoteRepository $noteRepository)
    {}

    public function createNote(int $userId, string $title, ?string $content, ?string $password, array $labelIds = []): Note
    {
        $note = Note::make(
            userId:$userId,
            title:$title,
            content:$content,
            password:$password,
        );
        $this->noteRepository->save($note);
        $note->labels()->sync($labelIds);
        return $note;
    }

    public function getAllNotes(int $userId)
    {
        return $this->noteRepository->getAll($userId);
    }

    public function findById(int $noteId): ?Note
    {
        return $this->noteRepository->findById($noteId);
    }
    public function update(
        Note $note,
        string $title,
        ?string $content = null,
        array $labelIds = []
    ): Note {
        $note->update([
            'title' => $title,
            'content' => $content,]);

        $note->labels()->sync($labelIds);
        return $note;
}

    public function delete(Note $note): void
    {
        $note->delete();
    }

    public function pin(Note $note): Note
    {
        $note->update([
            'pinned' => true,
            'pinned_at' => now(),
        ]);

        return $note;
    }

    public function unpin(Note $note): Note
    {
        $note->update([
            'pinned' => false,
            'pinned_at' => null,
        ]);

        return $note;
    }

    public function search(int $userId, string $keyword)
    {
        return $this->noteRepository->search($userId, $keyword);
    }

    public function filterByLabel(int $userId, int $labelId)
    {
        return $this->noteRepository->filterByLabel($userId, $labelId);
    }
}
