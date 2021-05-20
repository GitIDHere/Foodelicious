<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $model = User::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(10)->create()->each(function($user)
        {
            /**
             * Seed the UserProfile
             */
            $user->userProfile()->save(
                \App\Models\UserProfile::factory()->make()
            );
        });
    }
}
