<?php

namespace App\Http\Controllers\User;

use App\Events\RecipeCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeCreateRequest;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
    public function saveRecipe(RecipeCreateRequest $request, $username, Recipe $recipe)
    {
        $recipeFields = $request->all();
               
        $user = Auth::user();
        $userProfile = $user->userProfile;
        
        if ($userProfile)
        {
            $savePhotos = [];
            
            if ($request->files->has('photos')) {
                $paramPhotos = $request->files->all();    
                $savePhotos = $paramPhotos['photos'];
            }

            $deletePhotos = $request->input('delete_photos');
            
            $cookTimeHours = $recipeFields['cook_time_hours'];
            $cookTimeMin = $recipeFields['cook_time_minutes'];
            $recipeFields['cook_time'] = $cookTimeHours.':'.$cookTimeMin;
            
            if (is_array($recipeFields['cooking_steps'])) {
                $recipeFields['cooking_steps'] = json_encode($recipeFields['cooking_steps']);
            }
            
            $recipe = $this->recipeService->saveRecipe($userProfile, $recipe, $recipeFields, $savePhotos, $deletePhotos);
            
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
            
            $cookTimes = explode(':', $recipe->cook_time);
            $cookTimeHours = $cookTimes[0];
            $cookTimeMin = $cookTimes[1];
            
            $recipePhotos = $recipe->files->map(function($photoFile)
            {
                return  [
                    'id' => $photoFile->id,
                    'uri' => asset($photoFile->public_path),
                    'alt' => $photoFile->name
                ];
            });
            
            $recipeData = [
                'title' => $recipe->title,
                'description' => $recipe->description,
                'cooking_steps' => json_decode($recipe->cooking_steps),
                'cook_time_hours' => $cookTimeHours,
                'cook_time_minutes' => $cookTimeMin,
                'servings' => $recipe->servings,
                'preparations' => $recipe->prep_directions,
                'utensils' => $utensilsCSV,
                'ingredients' => $ingredientsCSV,
                'photos' => $recipePhotos->toArray(),
                'visibility' => $recipe->visibility,
            ];
                 
            return view('screens.user.recipes.view', ['data' => $recipeData, 'recipe' => $recipe]);
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