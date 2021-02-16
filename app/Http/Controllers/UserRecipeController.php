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
            $photos = [];
            
            if ($request->files->has('photos')) {
                $photos = $request->files->all();    
            }
            
            $recipe = $this->recipeService->createRecipe($userProfile, $recipeFields, $photos);
            
            if ($recipe)
            {
                // Send event
                RecipeCreated::dispatch($recipe);
                
                return redirect()->route('user.recipes.list')->with(['success' => 'Recipe added!']);
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
    
    
    /**
     * @param Request $request
     * @param $username
     * @param Recipe $recipe
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewRecipe(Request $request, $username, Recipe $recipe)
    {
        $user = Auth::user();
        $isUserRecipe = $user->userProfile->recipes->contains($recipe);
        
        if ($isUserRecipe) 
        {
            $ingredientsCSV = $this->getCSVFromJSON($recipe->ingredients);
            $utensilsCSV = $this->getCSVFromJSON($recipe->utensils);
    
            $recipeData = [
                'title' => $recipe->title,
                'description' => $recipe->description,
                'directions' => $recipe->directions, # JSON
                'cook_time' => $recipe->cook_time,
                'servings' => $recipe->servings,
                'preparations' => $recipe->prep_directions,
                'utensils' => $utensilsCSV, # JSON
                'ingredients' => $ingredientsCSV, # JSON
                'photos' => '', # JSON???
                'visibility' => $recipe->visibility,
            ];
                        
            return view('screens.user.recipes.recipe', ['recipe' => $recipeData]);
        } 
        else {
            // The recipe doesn't belong to the user
            return redirect()->route('home');
        }
    }
    
    
    
    /**
     * @param $json
     * @return string
     */
    private function getCSVFromJSON($json)
    {
        $jsonArr = json_decode($json);
        $csv = '';
        if ($jsonArr) {
            $csv = implode(',', $jsonArr);
        }
        return $csv;
    }
    
    
}