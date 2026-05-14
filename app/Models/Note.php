<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $password
 * @property Carbon|null pinned_at
 * @property int created_by // created by user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'content',
        'password',
        'pinned_at',
        'created_by'
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'pinned_at' => 'datetime',
        ];
    }

    public static function make(
        string $title,
        int $userId,
        ?string $content = null,
        ?string $password = null
    ): static {
        return new static ([
            'title' => $title,
            'content' => $content,
            'password' => $password,
            'created_by' => $userId
        ]);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(
            User::class, 'created_by', 'id'
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            NoteTag::class,
            'note_note_tag',
            'note_id',
            'note_tag_id'
        );
    }
}
