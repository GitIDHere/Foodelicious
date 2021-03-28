<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailUpdateRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var User 
     */
    public $user;
    
    /**
     * @var string 
     */
    public $oldEmail;
    
    
    /**
     * Create a new event instance.
     * @param User $user
     * @param string $oldEmail
     * @return void
     */
    public function __construct($user, $oldEmail)
    {
        $this->user = $user;
        $this->oldEmail = $oldEmail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
