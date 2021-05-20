<?php

namespace App\Providers;

use App\Events\EmailUpdateEvent;
use App\Events\UserLogin;
use App\Listeners\AppLogListener;
use App\Listeners\LogUserLogin;
use App\Listeners\PasswordResetListener;
use App\Listeners\UserEventSubscriber;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Log\Events\MessageLogged;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            // TODO - Log that the user has been verified
        ],
        MessageLogged::class => [
            AppLogListener::class,
        ],
        PasswordReset::class => [
            PasswordResetListener::class
        ],
        UserLogin::class => [
            LogUserLogin::class  
        ],
    ];
    
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
