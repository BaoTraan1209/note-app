<?php

namespace App\Queries\Note;

use App\Models\Note;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteHandler
{
    // ÄÃ¢y lÃ  class thá»±c hiá»‡n hÃ m execute Ä‘á»ƒ viáº¿t query cáº§n xá»­ lÃ½
    public function __construct()
    {

    }

    public function execute(NoteQuery $query): LengthAwarePaginator
    {
        $noteQuery = Note::query()
            ->with(['tags', 'shareUsers'])
            ->where('created_by', $query->userId)
            ->when(trim((string) $query->keyword) !== '', function ($builder) use ($query) {
                $keyword = trim((string) $query->keyword);

                $builder->where(function ($search) use ($keyword) {
                    $search->where('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%")
                        ->orWhereHas('tags', fn ($tag) => $tag->where('name', 'like', "%{$keyword}%"));
                });
            })
            ->orderByRaw('pinned_at IS NULL')
            ->orderByDesc('pinned_at')
            ->orderByDesc('updated_at');
//            ->get();

        // PhÃ¢n trang
        // SELECT * FROM notes -> phÃ¢n trang tá»« 1 Ä‘áº¿n 10
        $paginator = $noteQuery->paginate(
            perPage: $query->perPage, // 10
            columns: ['*'],
            page: $query->page, // 1
        );

        return $paginator;
    }
}

