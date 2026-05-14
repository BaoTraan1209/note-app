<?php

namespace App\Queries\Dashboard;

use App\Models\Note;
use App\Models\NoteTag;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardHandler
{
    public function __construct()
    {
        //
    }

    public function execute(DashboardQuery $query): array
    {
        $notes = Note::query()
            ->where('created_by', $query->userId)
            ->count();

        $notePinned = Note::query()
            ->where('created_by', $query->userId)
            ->whereNotNull('pinned_at')
            ->count();

        $noteLocked = Note::query()
            ->where('created_by', $query->userId)
            ->whereNotNull('password')
            ->count();

        $tags = NoteTag::query()
            ->whereHas('notes', function ($q) use ($query) {
                $q->where('created_by', $query->userId);
            })
            ->get()
            ->map(fn ($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
            ]);

        return [
            'total' => $notes,
            'pinned' => $notePinned,
            'locked' => $noteLocked,
            'tags' => $tags
        ];
    }
}
