<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Email
{
    use Queueable, SerializesModels;
    
    /**
     * @var string
     */
    public $passwordResetURL;
    
    /**
     * @var string
     */
    public $expirationDateTime;
    
    /**
     * @var string 
     */
    public $subject = 'Password reset request';
    
    
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
            ->view('emails.password_reset');
    }
    
}
