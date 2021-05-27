<?php

namespace App\Http\Controllers\Recipe;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecipeController extends Controller
{


    public function showRecipe(Request $request, Recipe $recipe)
    {

        /**
         * - Photos
         * - Stars/Thumbs ups
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

        $pageData = [
            'title' => $recipe->title,
            'description' => $recipe->description,
            'ratings' => 100,
            'cooking_steps' => $recipe->cooking_steps,
            'date_created' => $recipe->created_at->format('d/m/Y'),
            'utensils' => $recipe->utensils,
            'cook_time' => $recipe->cook_time,
            'username' => $recipe->userProfile->username,
            'photos' => $recipePhotos,
        ];


        return view('screens.recipe.view', [
            'recipe' => $pageData
        ]);
    }





}
