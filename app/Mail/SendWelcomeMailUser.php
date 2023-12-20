<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeMailUser extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $planDescription;
    public $limit;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $planDescription, $limit)
    {
        $this->name = $name;
        $this->planDescription = $planDescription;
        $this->limit = $limit;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'DEVinGYM - [DevInHouse]',
        );
    }


        public function build()
    {
        return $this->subject('DevInGym')
                    ->view('mails.welcome', [
                        'content' => [
                'name' => $this->name,
                'planName' => $this->planDescription,
                'limit' => $this->limit === null ? 'ILIMITADO' : $this->limit
                        ]
                    ]);
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'mails.welcome',
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
