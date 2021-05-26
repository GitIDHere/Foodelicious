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
         * - Ingredients
         * - Stars/Thumbs ups
         * - Title
         * - Cooking steps
         * - Date created
         * - Utensils
         * - Description
         * - Cook time
         * - User details
         *  - View user profile. Only the public recipes
         */

dd($recipe);





        return view('screens.recipe', [
            'recipe' => $recipe
        ]);
    }












}
