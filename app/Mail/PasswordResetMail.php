<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;
    protected string $name;
    protected User $user;
    protected string $token;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $data)
    {
        $this->token = $this->data['token'];
        $this->user  = $this->data['user'];
        $this->name  = $this->user->firstname;
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
        $reset_link = config('app.url').config('frontend.password_reset_url').$this->token;

        return new Content(
            markdown: 'emails.password_reset',
            with: [
                'name'      => $this->name,
                'link'      => $reset_link,
                'duration'  => config('app.password_reset_token_expiry')
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
