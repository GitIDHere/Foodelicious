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
     * @param $userProfile
     * @param $recipe
     * @param $recipeData
     * @param $savePhotos
     * @return mixed|null
     * @throws \Exception
     */
    public function saveRecipe($userProfile, $recipe, $recipeData, $savePhotos)
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
            $savedFiles = $this->recipePhotoService->savePhotos($savePhotos);

            if ($savedFiles->isNotEmpty())
            {
                $savedFiles->each(function($file)
                {
                    $this->recipePhotoService->makeThumbnail($file->path);
                });

                $recipe->files()->attach($savedFiles);
            }

            return $recipe;
        }

        return null;
    }

    /**
     * @param $recipe
     * @param $photosToDeleteIds
     * @throws \Exception
     */
    public function deletePhotos($recipe, $photosToDeleteIds)
    {
        $this->recipePhotoService->deletePhotos($recipe, $photosToDeleteIds);
    }

}
