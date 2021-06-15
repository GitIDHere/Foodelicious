<?php

namespace App\Http\Controllers\Recipe;

use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * @var RecipeService
     */
    private $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }


    public function showRecipe(Request $request, Recipe $recipe)
    {

        /**
         * - Photos
         * X- Stars/Thumbs ups
         * - Comments
         * X- Ingredients
         * X- Title
         * X- Cooking steps
         * X- Date created
         * X- Utensils
         * X- Description
         * X- Cook time
         * X- User details (username)
         *  - View user profile. Only the public recipes
         */


        $recipePhotos = $recipe->files->map(function($file)
        {
            return asset($file->public_path);
        })
        ->toArray();

        $favouriteCount = $recipe->recipeFavourites()->where('is_favourited', 1)->get()->count();

        $isFavourited = false;
        $user = Auth::user();

        if ($user)
        {
            $profile = $user->userProfile;

            // Get the favourite record for the user for this recipe
            $favourites = $profile->recipeFavourites()->where('recipe_id', $recipe->id)->first();

            $isFavourited = ($favourites && $favourites->is_favourited ?: false);
        }

        $recipeComments = $this->recipeService->getComments($recipe);

        $pageData = [
            'id' => $recipe->id,
            'title' => $recipe->title,
            'description' => $recipe->description,
            'favourites' => $favouriteCount,
            'servings' => $recipe->servings,
            'cooking_steps' => $recipe->cooking_steps,
            'date_created' => $recipe->created_at,
            'utensils' => $recipe->utensils,
            'cook_time' => $recipe->cook_time_formatted,
            'username' => $recipe->userProfile->username,
            'ingredients' => $recipe->ingredients,
            'photos' => $recipePhotos,
            'is_favourited' => $isFavourited,
            'is_published' => $recipe->is_published
        ];

        return view('screens.recipe.view', [
            'recipe' => $pageData,
            'comments' => $recipeComments
        ]);
    }





}
