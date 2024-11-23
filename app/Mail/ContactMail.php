<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

  
    public $email;
    

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $body)
    {
        $this->name= $name;
        $this->email= $email;
        $this->body = $body;
    }
    
    public function build()
    {
        return $this->subject('Liên hệ mới từ ' . $this->name)
                    ->view('email.contact')
                    ->with([
                        'name' => $this->name,
                        'email' => $this->email,
                        'body' => $this->body,
                    ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'StayNest',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.contact',
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
