<?php


namespace App\Contracts\Repositories;

use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;

interface ILabelRepository
{
    public function findById(int $id): ?Label;

    public function getAllByUser(int $userId): Collection;

    public function save(Label $label): Label;
}
