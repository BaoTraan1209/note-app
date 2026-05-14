<?php

namespace App\Repositories;

use App\Contracts\Repositories\INoteRepository;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository implements INoteRepository
{
    public function findById(int $id): ?Note
    {
        return Note::query()->with(['tags'])->find($id);
    }

    public function findUserNoteById(
        int $noteId,
        int $userId
    ): ?Note {
        return Note::query()
            ->where('created_by', $userId)
            ->with(['tags'])
            ->find($noteId);
    }

    public function getAll(): Collection
    {
        return Note::query()->with(['tags'])->get();
    }

    public function delete(Note $note): bool {
        return (bool) $note->delete();
    }

    public function save(Note $note): Note
    {
        $note->save();
        return $note;
    }
}
