<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string|null $color
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Note[] $notes
 */
class Label extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'color'
    ];

    public static function createLabel(int $user_id, string $name, string $slug, ?string $color = null): static
    {
        return new static ([
            'user_id' => $user_id,
            'name' => $name,
            'slug' => Str::slug($name),
            'color' => $color,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class)->withTimestamps();
    }
}
