<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;

Route::prefix('{username}/recipes')
    ->middleware(['user.verified', 'auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        Route::get('new', function(){
            return view('screens.user.recipe.new');
        })
        ->name('user.recipe.new');
        
        Route::post('new', [Controllers\UserRecipeController::class, 'createRecipe'])
        ->name('user.recipe.new.submit');
        
        Route::get('my-recipes', [Controllers\UserRecipeController::class, 'showRecipeList'])
        ->name('user.recipe.list');
        
        Route::get('{recipeId}', [Controllers\UserRecipeController::class, 'viewRecipe'])
        ->name('user.recipe.view')
        ;
    })
;
















