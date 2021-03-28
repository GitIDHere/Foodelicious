<?php namespace App\Listeners;


use App\Mail\EmailUpdateRequest;
use Illuminate\Support\Facades\Mail;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event) {
        
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event) {
        
    }
    
    /**
     * Send an email to the original email address notifying them that their email address has been updated.
     * @param $event
     */
    public function handleEmailUpdate($event)
    {
        $user = $event->user;
        $oldEmail = $event->oldEmail;
        $name = $user->userProfile->full_name;
        
        Mail::to($oldEmail)->send(new EmailUpdateRequest($name, $user));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            [UserEventSubscriber::class, 'handleUserLogin']
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            [UserEventSubscriber::class, 'handleUserLogout']
        );
        
        $events->listen(
            'App\Events\EmailUpdateRequest',
            [UserEventSubscriber::class, 'handleEmailUpdate']
        );
    }
}
