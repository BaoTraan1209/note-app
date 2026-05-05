<?php

namespace App\Services;

use App\Contracts\Repositories\ILabelRepository;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;

class LabelService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ILabelRepository $labelRepository
    ){}

    public function createLabel(string $name, int $userId, ?string $color=null): Label
    {
        $label = Label::cretaeLabel(
            user_id: $userId,
            name: $name,
            slug: \Str::slug($name),
            color: $color,
        );
        $this->labelRepository->save($label);
        return $label;
    }

    public function update(Label $label, string $name, int $userId, ?string $color=null): Label
    {
        $label->update([
            'name' => $name,
            'slug' => \Str::slug($name),
            'color' => $color,
        ]);

        return $label;
    }

    public function delete(Label $label):void
    {
        $label->delete();
    }
    public function getAllLabels(int $userId)
    {
        return $this->labelRepository->getAllByUser($userId);
    }
}
