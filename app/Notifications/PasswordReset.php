<?php

namespace App\Notifications;

use App\Services\Auth\PasswordResetService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class PasswordReset extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $token;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $user
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($user)
    {
        $username = $user->userProfile->username;

        $passwordResetService = App::make(PasswordResetService::class);
        $email = $passwordResetService->getEmail($this->token, $user->email, $username);

        return ($email)->to($user->email);
    }
}
