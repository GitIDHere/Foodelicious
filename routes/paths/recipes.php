<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;


Route::middleware(['auth'])->group(function()
{
    Route::get('/new-recipe', function(){
        return view('screens.recipe.new_recipe');
    })
    ->name('new_recipe.show')
    ;
    
    
    Route::post('/new-recipe', [Controllers\RecipeController::class, 'createRecipe'])
    ->name('new_recipe.submit')
    ;    
    
});
















