<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string|null $color
 */
class Label extends Model
{
    protected $table = 'labels';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = true;
    protected $fillable = [
        'name',
        'color',
        'created_by',
    ];

    public static function createLabel(int $userId, string $name, ?string $color = null): static
    {
        return new static ([
            'name' => $name,
            'color' => $color,
            'created_by' => $userId
        ]);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'label_notes', 'label_id', 'note_id');
    }
}
