<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;

class PasswordResetListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $msg = "User ".$user->email." reset their password";
        Log::log(LogLevel::INFO, $msg);
    }
}
