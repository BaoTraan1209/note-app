<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notes.{noteId}', function (User $user, int $noteId): bool {
    return Note::query()
        ->whereKey($noteId)
        ->where(function ($query) use ($user) {
            $query->where('created_by', $user->getKey())
                ->orWhereHas('shareUsers', fn ($share) => $share->where('users.id', $user->getKey()));
        })
        ->exists();
});
