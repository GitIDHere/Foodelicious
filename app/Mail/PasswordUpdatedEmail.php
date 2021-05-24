<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdatedEmail extends Email
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $subject = 'Your email has been updated';

    /**
     * Create a new message instance.
     * @param string $recipientName
     * @param User $user
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
        return $this->view('emails.password_updated');
    }
}
