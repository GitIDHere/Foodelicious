<?php

namespace App\Mail;

use App\Models\User;
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
     * @var User|null
     */
    public $user = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipientName, $user = null)
    {
        $this->recipientName = $recipientName;
        $this->signOff = env('MAIL_FROM_NAME', 'Foodelicious Team');
        $this->user = $user;
    }


    /**
     * Set tokens on the email. $token has to be a public property on the Email
     *
     * @param array $tokens
     * @param $value
     */
    public function setTokens(array $tokens)
    {
        foreach($tokens as $token => $value)
        {
            if (property_exists($this, $token)){
                $this->$token = $value;
            }
        }
    }



}
