<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
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
            subject: 'Verify your Email Address!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $token = $this->data['token'];

        $user  = $this->data['user'];

        $verification_link = config('app.url')."/verify/${token}";

        return new Content(
            markdown: 'emails.email_verify',
            with: [
                'name'      => $user->firstname,
                'link'      => $verification_link,
                'duration'  => config('app.email_verification_token_expiry')
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
