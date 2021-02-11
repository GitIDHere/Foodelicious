<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeCreateRequest;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    
    private $recipeService;
    
    
    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
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

        $this->recipeService->addEntry($userProfile, $recipeFields);
    }
    
    
    
}
