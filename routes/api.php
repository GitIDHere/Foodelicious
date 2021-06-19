<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API as APIControllers;

Route::middleware(['throttle:50,1'])->prefix('tags')->group(function()
{
    // api/tags/ingredient
    Route::get('ingredient', [APIControllers\TagListController::class, 'ingredientList']);
});


Route::middleware(['throttle:50,1', 'auth:sanctum'])->prefix('recipe')->group(function()
{
    // api/recipe/favourite
    Route::post('favourite', [APIControllers\RecipeFavouriteController::class, 'toggleFavourite']);

    // api/recipe/comment
    Route::post('comment', [APIControllers\RecipeCommentController::class, 'saveComment']);

    // api/recipe/comment
    Route::delete('comment', [APIControllers\RecipeCommentController::class, 'deleteComment']);
});

Route::middleware(['throttle:50,1', 'auth:sanctum'])->prefix('{recipe}')->group(function()
{
    // api/{recipe}/photos
    Route::post('photos', [APIControllers\RecipePhotoUploadController::class, 'savePhotos'])
        ->middleware(['user.recipe'])
    ;

    // api/{recipe}/photos
    Route::delete('photos', [APIControllers\RecipePhotoUploadController::class, 'deletePhotos'])
        ->middleware(['user.recipe'])
    ;
});
