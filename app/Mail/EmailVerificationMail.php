<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
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
            subject: 'Verify your Email Address!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $verification_link = config('app.url').config('frontend.email_verify_url').$this->token;

        return new Content(
            markdown: 'emails.email_verify',
            with: [
                'name'      => $this->name,
                'link'      => $verification_link,
                'duration'  => config('app.email_verification_token_expiry')
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
