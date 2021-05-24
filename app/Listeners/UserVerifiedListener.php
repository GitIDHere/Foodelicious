<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;

class UserVerifiedListener
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
     * @param  Verified $event
     * @return void
     */
    public function handle($event)
    {
        /** @var User $user */
        $user = $event->user;
        $msg = "User ".$user->email." has verified their email.";
        Log::log(LogLevel::INFO, $msg);
    }
}
