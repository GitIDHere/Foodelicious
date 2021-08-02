<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use App\Mail\VerifyEmail as VerificationEmail;
use Illuminate\Bus\Queueable;

class EmailVerification extends VerifyEmail
{
    use Queueable;

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
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        $username = $notifiable->userProfile->username;

        $verificationEmail = new VerificationEmail($username);

        $verificationEmail->setTokens([
            'verification_url' => $verificationUrl,
        ]);

        $verificationEmail->to($notifiable->email);

        return $verificationEmail;
    }

}
