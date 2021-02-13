<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;


Route::middleware(['auth'])->group(function()
{
    Route::get('/recipes/new', function(){
        return view('screens.recipe.new_recipe');
    })
    ->name('new_recipe.show')
    ;
    
    Route::post('/recipes/new', [Controllers\RecipeController::class, 'createRecipe'])
    ->name('new_recipe.submit')
    ;    
    
    
    
    
    
    
    
});
















