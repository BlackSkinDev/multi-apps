<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $data)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset your Password!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $token = $this->data['token'];

        $user  = $this->data['user'];

        $reset_link = config('app.url').config('frontend.password_reset_url').$token;

        return new Content(
            markdown: 'emails.password_reset',
            with: [
                'name'      => $user->firstname,
                'link'      => $reset_link,
                'duration'  => config('app.password_reset_token_expiry')
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
