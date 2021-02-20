<?php

namespace App\Services;

use App\Exceptions\Custom\CreateModelFailedException;
use App\Models\Recipe;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

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
     * @return Model|Recipe
     */
    public function saveRecipe($userProfile, $recipe, $recipeData, $photos)
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
            $savedFiles = $this->recipePhotoService->saveFiles($photos);
        
            if ($savedFiles->isNotEmpty()) 
            {
                $recipe->files()->attach($savedFiles);
            }
            
            return $recipe;
        }
        
        return null;
    }
    
    
    
    
    
    
    
    
    
    
}