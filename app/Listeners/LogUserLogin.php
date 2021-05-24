<?php

namespace App\Listeners;

use App\Events\UserLogin;
use App\Models\AppLog;

class LogUserLogin
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
     * @return void
     */
    public function handle(UserLogin $event)
    {
        $user = $event->getUser();
        if ($user) {
            $request = Request();
            $msg = 'User logged in: '.$user->id;
            AppLog::createLog($request, AppLog::TYPE_CUSTOM, $msg);
        }
    }
}
