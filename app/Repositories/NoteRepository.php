<?php

namespace App\Repositories;

use App\Contracts\Repositories\INoteRepository;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository implements INoteRepository
{
    public function findById(int $id): ?Note
    {
        return Note::query()->find($id);
    }

    public function getAll(int $userId): Collection
    {
        return Note::query()
            ->where('created_by', $userId)
            ->orderByDesc('pinned')
            ->orderByDesc('pinned_at')
            ->latest()
            ->get();
    }

    public function save(Note $note): Note
    {
        $note->save();
        return $note;
    }

    public function search(int $userId, string $keyword): Collection
    {
        return Note::query()
            ->where('created_by', $userId)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('content', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('pinned')
            ->orderByDesc('pinned_at')
            ->latest()
            ->get();

    }

    public function filterByLabel(int $userId, int $labelId): Collection
    {
        return Note::query()->with('labels')
            ->where('created_by', $userId)
            ->orderByDesc('pinned')
            ->orderByDesc('pinned_at')
            ->latest()
            ->get();
    }
}
