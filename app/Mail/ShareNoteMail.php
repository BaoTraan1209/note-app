<?php

namespace App\Mail;

use App\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShareNoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Note $note,
        public string $senderName,
        public string $noteUrl,
        public string $permission = 'read'
    ) { }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name', 'NoteNest').' - note shared: '.$this->note->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.share-note',
            with: [
                'note' => $this->note,
                'senderName' => $this->senderName,
                'noteUrl' => $this->noteUrl,
                'permission' => $this->permission,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}