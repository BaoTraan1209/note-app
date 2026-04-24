<?php

namespace App\Contracts\Repositories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

interface INoteRepository
{
    public function findById(int $id): ?Note;
    public function getAll(): Collection;
    public function save(Note $note): Note;
}
