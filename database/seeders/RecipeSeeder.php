<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\RecipeMetadata;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    private $seedCount = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = UserProfile::all();

        // For each of the
        for($i = 0; $i < $this->seedCount; $i++)
        {
            $userProfile = $profiles->random();
            $recipe = \App\Models\Recipe::factory()->makeOne();

            // At this point the recipe is saved
            $recipe = $userProfile->recipes()->create($recipe->toArray());

            // Create a file
            $files = File::factory()->count(2)->create();
            $recipe->files()->attach($files);

            $recipeMetaData = RecipeMetadata::factory()->count(1)->make()->first();
            $recipe->recipeMetadata()->create($recipeMetaData->toArray());
        }
    }
}
