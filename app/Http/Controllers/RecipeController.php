<?php

namespace App\Http\Controllers;

use App\Events\RecipeCreated;
use App\Http\Requests\RecipeCreateRequest;
use App\Services\RecipeService;
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
        $recipeFields = $request->all();
    
        $user = Auth::user();
        $userProfile = $user->userProfile;

        if ($userProfile) 
        {
            $files = $request->files->all();
            $recipe = $this->recipeService->createRecipe($userProfile, $recipeFields, $files['photos']);
            
            if ($recipe) 
            {
                // Send event
                RecipeCreated::dispatch($recipe);
                
                return redirect()->route('my_recipes')->with(['success' => 'Recipe added!']);       
            } 
            else {
                return back()->withErrors(['Failed to create recipe']);
            }
        } 
        else {
            // Error
            return redirect()->route('login.show')->withErrors(['User profile not found.']);
        }
    }
    
    
    
}






