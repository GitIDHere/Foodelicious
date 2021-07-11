<?php

namespace Database\Seeders;

use App\Models\RecipeMetadata;
use App\Models\UserProfile;
use App\Services\RecipePhotoService;
use App\Services\RecipeViewService;
use Faker\Factory;
use Illuminate\Database\Seeder;
use \Symfony\Component\HttpFoundation;
use Illuminate\Support\Facades\Storage;

class RecipeSeeder extends Seeder
{
    /**
     * @var int
     */
    private $seedCount = 10;

    /**
     * @var int
     */
    private $maxRecipeImgs = 3;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var RecipePhotoService
     */
    private $recipePhotoService;

    /**
     * @var RecipeViewService
     */
    private $recipeViewService;


    public function __construct(RecipePhotoService $recipePhotoService, RecipeViewService $recipeViewService)
    {
        $this->recipePhotoService = $recipePhotoService;
        $this->recipeViewService = $recipeViewService;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
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

            $recipePhotoFiles = $this->createPhotos($recipe);

            // Attach the img file to the recipe
            $recipe->files()->attach($recipePhotoFiles);

            $recipeMetaData = RecipeMetadata::factory()->count(1)->make()->first();
            $recipe->recipeMetadata()->create($recipeMetaData->toArray());

            if ($recipe->is_published)
            {
                $this->doFavouriteRecipe($userProfile, $recipe);
                $this->doCommentRecipe($userProfile, $recipe);
            }
        }
    }


    /**
     * @param $userProfile
     * @param $recipe
     * @param $comment
     */
    private function doCommentRecipe($userProfile, $recipe)
    {
        $comment = $this->faker->sentence;
        $this->recipeViewService->saveComment($userProfile, $recipe, $comment);
    }


    /**
     * @param $userProfile
     * @param $recipe
     */
    private function doFavouriteRecipe($userProfile, $recipe)
    {
        $this->recipeViewService->favourite($userProfile, $recipe);
    }

    /**
     * @param $recipe
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    private function createPhotos($recipe)
    {
        // Create a collection and store the recipe images in there. Only 1 image for now
        $recipeImgs = collect();

        $privateStorage = Storage::disk('private');
        $recipeSeedImages = $privateStorage->allFiles('seeds/img/recipes');

        for ($i = 0; $i < rand(1, $this->maxRecipeImgs); $i++)
        {
            // Get a random image from the seed recipe image folder
            $recipeImgFileName = $recipeSeedImages[rand(0, count($recipeSeedImages) - 1)];
            $recipeImgFile = new HttpFoundation\File\File($privateStorage->path($recipeImgFileName));
            $recipeImgs->add($recipeImgFile);
        }

        // Use recipePhotoService to save the photo into storage directory
        $recipePhotoFiles = $this->recipePhotoService->savePhotos($recipeImgs);

        $recipePhotoFiles->each(function($photoFile)
        {
            // Create a thumbnail of the image
            $this->recipePhotoService->makeThumbnail($photoFile->path);
            $photoFile->update(['is_attached' => true]);
        });

        return $recipePhotoFiles;
    }

}
