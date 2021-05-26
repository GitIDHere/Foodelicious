<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Recipe as Controllers;

Route::prefix('recipes')
    ->middleware(['recipe.route'])
    ->group(function()
    {
        /*
         * Show a recipe belonging
         */
        Route::get('{recipe}/{recipe_title}', [Controllers\RecipeController::class, 'showRecipe'])
            ->name('recipe.show')
        ;
    })
;
