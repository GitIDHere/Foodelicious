<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}/recipes')
    ->middleware(['user.verified', 'auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        /**
         * Create a recipe
         */
        Route::get('create', function(){
            return view('screens.user.recipes.view');
        })
        ->name('user.recipes.create.view');
        
        /**
         * Show a list of recipe belonging to the user
         */
        Route::get('my-recipes', [Controllers\UserRecipeController::class, 'showRecipeList'])
        ->name('user.recipes.list');
        
        /**
         * Show a single recipe
         */
        Route::get('{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
        ->name('user.recipes.view');
    
        /**
         * Create a recipe
         */
        Route::post('create', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->name('user.recipes.create.submit');
        
        /**
         * Save/update a recipe
         */
        Route::post('{recipe}', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->name('user.recipes.save.submit');
    })
;
