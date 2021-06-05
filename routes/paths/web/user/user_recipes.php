<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}/recipes')
    ->middleware(['auth', 'url.parameters', 'user.routes'])
    ->group(function()
    {
        /*
         * Show a form to create a recipe
         */
        Route::get('create', function(){
            return view('screens.user.recipes.view');
        })
            ->middleware(['user.verified'])
            ->name('user.recipes.create.view')
        ;

        /*
         * Show a single recipe
         */
        Route::get('{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.view')
        ;

        /*
         * Create a recipe POST request
         */
        Route::post('create', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->middleware(['user.verified'])
            ->name('user.recipes.create.submit')
        ;

        /*
         * Save/update a recipe
         */
        Route::post('{recipe}', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.save.submit')
        ;
    })
;
