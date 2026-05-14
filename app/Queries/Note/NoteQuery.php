<?php

namespace App\Queries\Note;

class NoteQuery
{
    // Khởi tạo tổng hợp data trước khi execute
    public function __construct(
        public int $page,
        public int $perPage,
        public int $userId
    ) {

    }
}
