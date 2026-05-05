<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{
    public function __construct()
    {

    }

    public function createNote(string $title, int $userId, ?string $content, ?string $password): Note
    {
        $note = Note::make(
            title:$title,
            userId:$userId,
            content:$content,
            password:$password,
        );
        $this->noteRepository->save($note);
        return $note;

    }


}
