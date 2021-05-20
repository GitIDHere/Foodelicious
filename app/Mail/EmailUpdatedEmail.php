<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class EmailUpdatedEmail extends Email
{
    use Queueable, SerializesModels;
    
    /**
     * @var string 
     */
    public $subject = 'Someone requested to update your email';
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipientName, $user)
    {
        parent::__construct($recipientName, $user);
    }
    
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email_updated');
    }
}
