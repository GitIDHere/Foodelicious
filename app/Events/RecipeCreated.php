<?php

namespace App\Events;

use App\Models\Recipe;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecipeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Recipe
     */
    private $recipe;

    /**
     * @var string
     */
    private $uuid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($uuid, Recipe $recipe)
    {
        $this->uuid = $uuid;
        $this->recipe = $recipe;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @return string
     */
    public function getUUID()
    {
        return $this->uuid;
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
