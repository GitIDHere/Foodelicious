<?php namespace App\Listeners;


use App\Mail\EmailUpdatedEmail;
use App\Mail\PasswordUpdatedEmail;
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
        
        Mail::to($oldEmail)->send(new EmailUpdatedEmail($name, $user));
    }

    /**
     * Send an email to the user notifying them that their password has been updated
     * 
     * @param $event
     */
    public function handlePasswordUpdate($event)
    {
       $user = $event->user;
       $name = $user->userProfile->full_name;
       
       Mail::to($user->email)->send(new PasswordUpdatedEmail($name, $user));
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
            'App\Events\EmailUpdateEvent',
            [UserEventSubscriber::class, 'handleEmailUpdate']
        );
    
        $events->listen(
            'App\Events\PasswordUpdateEvent',
            [UserEventSubscriber::class, 'handlePasswordUpdate']
        );
    }
}
