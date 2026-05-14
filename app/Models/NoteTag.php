<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class NoteTag extends Model
{
    protected $table = 'note_tags';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'name',
        'created_by'
    ];

    public static function make(
        string $name,
        int $userId
    ): static {
        return new static([
            'name' => $name,
            'created_by' => $userId
        ]);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(
            Note::class,
            'note_note_tag', // pivot
            'note_tag_id',
            'note_id'
        );
    }
}
