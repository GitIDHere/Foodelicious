<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RecipeRoute
{
    public function handle(Request $request, Closure $next)
    {
        $hasRecipeRoute = $request->route()->hasParameter('recipe');
        $hasRecipeTitleRoute = $request->route()->hasParameter('recipe_title');

        $failed = true;

        if ($hasRecipeRoute && $hasRecipeTitleRoute)
        {
            $recipe = $request->route()->parameter('recipe');
            $recipeTitle = $request->route()->parameter('recipe_title');

            $recipeTitle = str_ireplace('_', ' ', trim($recipeTitle));

            if ($recipe->visibility == 'public')
            {
                // Make sure that the recipe matches the recipe title from the URL
                if ($recipe->title == $recipeTitle) {
                    $failed = false;
                }
            }
        }

        if ($failed) {
            return redirect()->route('home');
        }


        return $next($request);
    }
}
