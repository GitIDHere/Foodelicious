<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeCreateRequest;
use App\Services\RecipePhotoService;
use App\Services\RecipeService;
use Illuminate\Http\Request;
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
            $files = $request->files->all();
            
            $vals = $this->recipePhotoService->saveFiles($files);
            dd($vals);
            //$recipe = $userProfile->recipes()->create($recipeFields);
            
            
        } 
        else {
            // Error
        }
        
    }
    
    
    
}



























