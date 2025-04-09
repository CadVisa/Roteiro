<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContatoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $contato)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo contato #: ' . $this->contato->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'externo.emails.contato',
            text: 'externo.emails.contato-text',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
