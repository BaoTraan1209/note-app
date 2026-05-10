<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $noteId
 * @property string $title
 * @property string|null $content
 * @property string|null $password
 * @property int $created_by // created by user
 * @property bool $pinned
 * @property string|null $color
 */
class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'noteId';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'content',
        'password',
        'created_by',
        'pinned',
        'color'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'pinned' => 'boolean',
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
        return $this->belongsTo(User::class, 'created_by', 'userId');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_notes', 'noteId', 'labelId');
    }
    public function share(): HasMany
    {
        return $this->hasMany(NoteShare::class, 'noteShareId', 'noteId');
    }
}
