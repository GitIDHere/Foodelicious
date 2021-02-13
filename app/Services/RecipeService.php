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
     * @param array $recipeData
     * @return Model|Recipe
     */
    public function createRecipe($userProfile, $recipeData, $photos)
    {
        $recipe = $userProfile->recipes()->create($recipeData);
    
        if ($recipe)
        {
            $savedFiles = $this->recipePhotoService->saveFiles($photos);
        
            if (!empty($savedFiles))
            {
                $recipe->files()->attach($savedFiles);
                return $recipe;
            }
        }
        
        return null;
    }
    
    
    
    
    
    
    
    
    
    
}