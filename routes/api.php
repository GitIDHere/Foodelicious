<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API as APIControllers;

Route::middleware(['throttle:50,1'])->prefix('tags')->group(function()
{
    Route::get('ingredient', [APIControllers\TagListController::class, 'ingredientList']);
});


Route::middleware(['throttle:50,1', 'auth:sanctum'])->prefix('recipe')->group(function()
{
    Route::post('favourite', [APIControllers\RecipeFavouriteController::class, 'toggleFavourite']);

    Route::post('comment', [APIControllers\RecipeCommentController::class, 'saveComment']);
});
