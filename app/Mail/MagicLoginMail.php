<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLoginMail extends Mailable
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
        $app_name =  config('app.name');
        return new Envelope(
            subject:"{$this->name} - This is your sign-in link to {$app_name}"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $magic_link = config('app.url').config('frontend.login_url').$this->token;

        return new Content(
            markdown: 'emails.magic_login_mail',
            with: [
                'name'      => $this->name,
                'link'      => $magic_link,
                'duration'  => config('app.magic_link_token_expiry')
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
