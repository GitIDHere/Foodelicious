<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Recipe as Controllers;

Route::prefix('recipe')
    ->group(function()
    {
        /*
         * Show a recipe
         */
        Route::get('{recipe}/{recipe_title}', [Controllers\RecipeController::class, 'showRecipe'])
            ->middleware(['recipe.route'])
            ->name('recipe.show')
        ;
    })
;
