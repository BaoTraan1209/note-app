<?php

namespace App\Repositories;

use App\Contracts\Repositories\ILabelRepository;
use App\Models\Label;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class LabelRepository implements ILabelRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function findById(int $id): ?Label
    {
        return Label::query()->find($id);
    }
    public function getAllByUser(int $userId): Collection
    {
        return Label::query()
            ->where('user_id', $userId)
            ->get();
    }

    public function delete(Label $label): void
    {
        $label->delete();
    }

    public function save(Label $label): Label
    {
        $label->save();
        return $label;
    }
}
