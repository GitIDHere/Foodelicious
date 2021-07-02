<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::middleware(['auth', 'url.parameters', 'user.routes'])
    ->prefix('{username}')
    ->group(function()
    {
        /*
         * Show a list of recipe belonging to the user
         */
        Route::get('recipes', [Controllers\UserRecipeController::class, 'showRecipeList'])
            ->name('user.recipes.list')
        ;

        /*
         * Search user's recipe list
         */
        Route::post('search', [Controllers\UserRecipeController::class, 'searchRecipe'])
            ->prefix('recipes')
            ->name('user.recipes.search.submit')
        ;

        /*
         * Show a form to create a recipe
         */
        Route::get('create', function(){
            return view('screens.user.recipes.view');
        })
            ->prefix('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.create.view')
        ;

        /*
         * Show a single recipe
         */
        Route::get('{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
            ->prefix('recipe')
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.view')
        ;

        /*
         * Create a recipe POST request
         */
        Route::post('create', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->prefix('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.create.submit')
        ;

        /*
         * Save/update a recipe
         */
        Route::post('{recipe}', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->prefix('recipe')
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.save.submit')
        ;
    })
;
