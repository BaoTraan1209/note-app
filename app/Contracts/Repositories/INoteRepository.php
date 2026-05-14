<?php

namespace App\Contracts\Repositories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

interface INoteRepository
{
    public function findById(int $id): ?Note;
    public function findUserNoteById(int $noteId, int $userId): ?Note;
    public function getAll(): Collection;
    public function delete(Note $note): bool;
    public function save(Note $note): Note;
}
