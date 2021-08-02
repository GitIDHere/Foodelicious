<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Email
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $expirationDateTime;

    /**
     * @var string
     */
    public $verification_url;

    /**
     * @var string
     */
    public $subject = 'Please verify your email';


    /**
     * Create a new message instance.
     *
     * @param $recipientName
     * @return void
     */
    public function __construct($recipientName)
    {
        parent::__construct($recipientName);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('emails.verify_email');
    }

}
