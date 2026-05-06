<?php

namespace App\Contracts\Repositories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

interface INoteRepository
{
    public function findById(int $id): ?Note;
    public function getAll(int $userId): Collection;
    public function save(Note $note): Note;
    public function search( int $userId, string $keyword): Collection;
    public function filterByLabel(int $userId, int $labelId): Collection;
}
