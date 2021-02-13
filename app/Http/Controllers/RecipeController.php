<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeCreateRequest;
use App\Services\RecipePhotoService;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    
    private $recipePhotoService;
    
    
    public function __construct(RecipePhotoService $recipePhotoService)
    {
        $this->recipePhotoService = $recipePhotoService;
    }
    
    
    public function createRecipe(RecipeCreateRequest $request)
    {
        /*
         * - Save the recipe
         * - Save the JSON correctly
         * - Save the files
         * - Attach the files to the recipe
         * - Return response message
         *  - Test with failure scenario.
         *  - Show errors
         * - Send an event
         */
    
        $recipeFields = $request->all();
    
        $user = Auth::user();
        $userProfile = $user->userProfile;

        if ($userProfile) 
        {
            $recipe = $userProfile->recipes()->create($recipeFields);
            
            if ($recipe) 
            {
                $files = $request->files->all();
                $savedFiles = $this->recipePhotoService->saveFiles($files['photos']);
                
                if (!empty($savedFiles)) 
                {
                    $recipe->files()->attach($savedFiles);    
                }
            }
        } 
        else {
            // Error
        }
        
    }
    
    
    
}






