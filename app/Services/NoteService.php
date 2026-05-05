<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{
    public function __construct()
    {

    }

    public function createNote(int $userId, string $title, ?string $content, ?string $password): Note
    {
        $note = Note::make(
            userId:$userId,
            title:$title,
            content:$content,
            password:$password,
        );
        $this->NoteRepository()->save($note);
        return $note;

    }


}
