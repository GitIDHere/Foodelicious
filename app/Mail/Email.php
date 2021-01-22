<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * The name of the recipient of the email
     * 
     * @var string
     */
    public $recipientName;
    
    /**
     * The sign off name
     * 
     * @var mixed|string 
     */
    public $signOff = '';
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipientName)
    {
        $this->recipientName = $recipientName;
        $this->signOff = env('MAIL_FROM_NAME', 'MyJourney Team');
    }
    
    
    /**
     * Set tokens on the email. $token has to be a public property on the Email
     * 
     * @param $token
     * @param $value
     */
    public function setToken($token, $value) {
        if (property_exists($this, $token)){
            $this->$token = $value;
        }
    }
    
    
    
}
