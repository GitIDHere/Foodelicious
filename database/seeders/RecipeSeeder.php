<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    
    
    
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = UserProfile::all();
        
        // For each of the
        for($i = 0; $i < 10; $i++)
        {
            $userProfile = $profiles->random();
            $recipe = \App\Models\Recipe::factory()->makeOne(); 
            $userProfile->recipes()->create($recipe->toArray());
        }
    }
}
