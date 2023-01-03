<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserNewLoginFromAnotherIpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ip;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$ip)
    {
        $this->user = $user;
        $this->ip = $ip;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'User New Login From Another Ip Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.UserLoginFromAnotherIp',
            with: [
                'user'  =>  $this->user,
                'ip'    =>  $this->ip,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
