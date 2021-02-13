<?php

namespace App\Http\Controllers;

use App\Events\RecipeCreated;
use App\Http\Requests\RecipeCreateRequest;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserRecipeController extends Controller
{
    /**
     * @var RecipeService
     */    
    private $recipeService;
    
    
    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }
    
    
    /**
     * @param RecipeCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRecipeList(Request $request)
    {
        // Get the user's recipes
        $user = Auth::user();
        $userProfile = $user->userProfile;
        
        return view('screens.user.recipes.list')->with('recipes', $userProfile->recipes);
    }
    
    
    public function viewRecipe(Request $request)
    {
        /**
         * - Make sure that the recipe belongs to the user
         */
        
        
    }
    
}