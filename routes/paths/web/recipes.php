<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Recipe as Controllers;

Route::prefix('recipe')
    ->group(function()
    {
        /*
         * Show a recipe belonging
         */
        Route::get('{recipe}/{recipe_title}', [Controllers\RecipeController::class, 'showRecipe'])
            ->middleware(['recipe.route'])
            ->name('recipe.show')
        ;

        /*
         * Show a recipe belonging
         */
        Route::get('preview/{recipe}/{recipe_title}', [Controllers\RecipeController::class, 'previewRecipe'])
            ->middleware(['user.recipe'])
            ->name('recipe.preview')
        ;
    })
;
