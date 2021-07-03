<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;
use \App\Http\Controllers\Recipe\RecipeController;

Route::prefix('{username}')
    ->middleware(['auth', 'user.routes', 'url.parameters'])
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
        Route::post('recipes/search', [Controllers\UserRecipeController::class, 'searchRecipe'])
            ->name('user.recipes.search.submit')
        ;

        /*
         * Show a form to create a recipe
         */
        Route::get('recipe/create', function(){
            return view('screens.user.recipes.view');
        })
            ->middleware(['user.verified'])
            ->name('user.recipes.create.view')
        ;

        /*
         * Show a single recipe
         */
        Route::get('recipe/{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.view')
        ;

        /*
         * Create a recipe POST request
         */
        Route::post('recipe/create', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->middleware(['user.verified'])
            ->name('user.recipes.create.submit')
        ;

        /*
         * Save/update a recipe
         */
        Route::post('recipe/{recipe}', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->whereNumber('recipe')
            ->middleware(['user.verified'])
            ->name('user.recipes.save.submit')
        ;

        /*
         * Show a recipe belonging
         */
        Route::get('preview/recipe/{recipe}', [RecipeController::class, 'previewRecipe'])
            ->middleware(['user.recipe'])
            ->name('recipe.preview')
        ;

    })
;
