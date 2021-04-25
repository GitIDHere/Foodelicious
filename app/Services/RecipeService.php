<?php

namespace App\Services;

use App\Models\File;
use App\Models\Recipe;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    private $recipePhotoService;

    public function __construct(RecipePhotoService $recipePhotoService)
    {
        $this->recipePhotoService = $recipePhotoService;
    }

    /**
     * @param UserProfile $userProfile
     * @param Recipe $recipe
     * @param array $recipeData
     * @param File[] $recipeData
     * @param [] $deletePhotos
     * @return Model|Recipe
     * @throws \Exception
     */
    public function saveRecipe($userProfile, $recipe, $recipeData, $savePhotos, $deletePhotos)
    {
        // Check $recipe is already attached to the user
        $isUserRecipe = $userProfile->recipes->contains($recipe);

        if ($isUserRecipe) {
            // Update the recipe
            $recipe->fill($recipeData)->save();
        }
        else {
            // Create new recipe
            $recipe = $userProfile->recipes()->create($recipeData);
        }

        if ($recipe)
        {
            $driver = Storage::drive(PhotoService::VISIBILITY_PUBLIC);
            $this->recipePhotoService->setDriver($driver);

            $savedFiles = $this->recipePhotoService->savePhotos($savePhotos);

            if ($savedFiles->isNotEmpty())
            {
                $savedFiles->each(function($file)
                {
                    $this->recipePhotoService->makeThumbnail($file->path);
                });

                $recipe->files()->attach($savedFiles);
            }

            $this->recipePhotoService->deletePhotos($recipe, $deletePhotos);

            return $recipe;
        }

        return null;
    }


}
