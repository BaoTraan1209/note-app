<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    public function sendSuccessResponse($data = [], $code = 200, $success = true, $msg = 'Success'): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'success' => $success,
            'data' => $data,
            'msg' => $msg,
            'time' => time()
        ], $code);
    }

    public function sendSuccessPaginateResponse(
        ?LengthAwarePaginator $paginator = null, $data = [], int $code = 200, bool $success = true, string $msg = 'Success'
    ): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'success' => $success,
            'data' => $data,
            'meta' => [
                'current_page' => $paginator?->currentPage() ?: 1,
                'last_page' => $paginator?->lastPage() ?: 1,
                'per_page' => $paginator?->perPage() ?: 10,
                'total' => $paginator?->total() ?: 0,
            ],
            'msg' => $msg,
            'time' => now()->timestamp,
        ], $code);
    }

    protected function validPagination($perPage, $page): bool
    {
        $maxPerPage = (int) config('app.max_per_page', 100);
        return $perPage >= 1 && $perPage <= $maxPerPage && $page >= 1;
    }
}
