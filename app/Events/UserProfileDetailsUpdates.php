<?php

namespace App\Events;

use App\Models\UserProfile;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserProfileDetailsUpdates
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user_profile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserProfile $userProfile)
    {
        $this->user_profile = $userProfile;
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
