<?php

namespace App\Queries\Note;

use App\Models\Note;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteHandler
{
    // Đây là class thực hiện hàm execute để viết query cần xử lý
    public function __construct()
    {

    }

    public function execute(NoteQuery $query): LengthAwarePaginator
    {
        $noteQuery = Note::query()
            ->where('created_by', $query->userId)
            ->orderByRaw('pinned_at IS NULL')
            ->orderByDesc('pinned_at')
            ->orderByDesc('updated_at');
//            ->get();

        // Phân trang
        // SELECT * FROM notes -> phân trang từ 1 đến 10
        $paginator = $noteQuery->paginate(
            perPage: $query->perPage, // 10
            columns: ['*'],
            page: $query->page, // 1
        );

        return $paginator;
    }
}
