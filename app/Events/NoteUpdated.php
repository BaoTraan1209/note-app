<?php

namespace App\Events;

use App\Models\Note;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoteUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Note $note,
        public int $editorId,
    ) {
        $this->note->loadMissing(['tags']);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notes.'.$this->note->getKey()),
        ];
    }

    public function broadcastAs(): string
    {
        return 'note.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'editor_id' => $this->editorId,
            'note' => [
                'id' => $this->note->getKey(),
                'title' => $this->note->title,
                'content' => $this->note->content,
                'font_size' => $this->note->font_size,
                'is_pinned' => (bool) $this->note->pinned_at,
                'tags' => $this->note->tags->pluck('name')->values()->all(),
                'updated_at' => optional($this->note->updated_at)->toIso8601String(),
            ],
        ];
    }
}
