<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;

Route::prefix('{username}/recipes')
    ->middleware(['user.verified', 'auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        Route::get('create', function(){
            return view('screens.user.recipes.recipe');
        })
        ->name('user.recipes.create.view');
        
        Route::get('my-recipes', [Controllers\UserRecipeController::class, 'showRecipeList'])
        ->name('user.recipes.list');
        
        Route::get('{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
        ->name('user.recipes.view');
    
        Route::post('create', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->name('user.recipes.create.submit');
        
        Route::post('{recipe}', [Controllers\UserRecipeController::class, 'saveRecipe'])
            ->name('user.recipes.save.submit');
    })
;
