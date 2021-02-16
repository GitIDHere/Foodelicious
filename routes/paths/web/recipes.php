<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;

Route::prefix('{username}/recipes')
    ->middleware(['user.verified', 'auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        Route::get('new', function(){
            return view('screens.user.recipes.recipe');
        })
        ->name('user.recipes.new');
        
        Route::post('new', [Controllers\UserRecipeController::class, 'createRecipe'])
        ->name('user.recipes.new.submit');
        
        Route::get('my-recipes', [Controllers\UserRecipeController::class, 'showRecipeList'])
        ->name('user.recipes.list');
        
        Route::get('{recipe}', [Controllers\UserRecipeController::class, 'viewRecipe'])
        ->name('user.recipes.view')
        ;
    })
;
