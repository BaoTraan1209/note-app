<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $password
 * @property int $created_by // created by user
 * @property bool $pinned
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $pinned_at
 */
class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'content',
        'password',
        'created_by',
        'pinned',
        'pinned_at',
        'color'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'pinned' => 'boolean',
            'pinned_at' => 'datetime',
        ];
    }

    public static function make(int $userId, string $title, ?string $content = null, ?string $password = null): static
    {
        return new static ([
            'title' => $title,
            'content' => $content,
            'password' => $password,
            'created_by' => $userId
        ]);
    }

    // mối quan hệ
    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class)->withTimestamps();
    }

}
