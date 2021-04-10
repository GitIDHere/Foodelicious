<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

    private static $user_id_sequence = 0;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // We want the user_id to the the same as the `id` column in the users table
        self::$user_id_sequence += 1;
        
        return [
            'user_id' => self::$user_id_sequence,
            'username' => $this->faker->userName,
            'description' => $this->faker->words(15, true)
        ];
    }
}
