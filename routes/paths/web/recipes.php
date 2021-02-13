<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;

Route::prefix('{username}/recipes')
->middleware(['auth', 'url.parameters', 'user.routes'])
->group(function() 
{
    Route::get('new', function(){
        return view('screens.recipe.new_recipe');
    })
    ->name('new_recipe.show');
    
    Route::post('new', [Controllers\RecipeController::class, 'createRecipe'])
    ->name('new_recipe.submit');
    
    
    // my_recipes
    //Route::get('recipes')
});
















