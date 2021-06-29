<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::middleware(['auth', 'url.parameters', 'user.routes'])
    ->group(function()
    {
        /*
         * Show a list of recipe belonging to the user
         */
        Route::get('', [Controllers\UserRecipeController::class, 'showRecipeList'])
            ->prefix('{username}/recipes')
            ->name('user.recipes.list')
        ;

        /*
         * Search user's recipe list
         */
        Route::post('search', [Controllers\UserRecipeController::class, 'searchRecipe'])
            ->prefix('{username}/recipes')
            ->name('user.recipes.search.submit')
        ;

        /*
         * Show a form to create a recipe
         */
        Route::get('create', function(){
            return view('screens.user.recipes.view');
        })
            ->prefix('{username}/recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.create.view')
        ;

        /*
         * Show a single recipe
         */
        Route::get('{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
            ->prefix('{username}/recipe')
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.view')
        ;

        /*
         * Create a recipe POST request
         */
        Route::post('create', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->prefix('{username}/recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.create.submit')
        ;

        /*
         * Save/update a recipe
         */
        Route::post('{recipe}', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->prefix('{username}/recipe')
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.save.submit')
        ;
    })
;
