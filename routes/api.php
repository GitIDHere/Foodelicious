<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API as APIControllers;

/**
 * Get tags
 */
Route::middleware(['throttle:50,1'])
    ->prefix('tags')
    ->group(function()
{
    // api/tags/ingredient
    Route::get('ingredient', [APIControllers\TagListController::class, 'ingredientList']);
});


/**
 * Routes to favourite and comment on recipe
 */
Route::middleware(['throttle:50,2', 'auth:sanctum'])
    ->prefix('recipe')
    ->group(function()
{
    // api/recipe/favourite
    Route::post('favourite', [APIControllers\RecipeFavouriteController::class, 'toggleFavourite']);

    // api/recipe/comment
    Route::post('comment', [APIControllers\RecipeCommentController::class, 'saveComment']);

    // api/recipe/comment
    Route::delete('comment', [APIControllers\RecipeCommentController::class, 'deleteComment']);
});

/**
 * Route to handle photo upload for existing recipes
 */
Route::middleware(['throttle:50,2', 'auth:sanctum'])
    ->prefix('{recipe}')
    ->group(function()
{
    // api/{recipe}/photos
    Route::post('photos', [APIControllers\RecipePhotoUploadController::class, 'savePhotos'])
        ->middleware(['user.recipe'])
    ;

    // api/{recipe}/photos
    Route::delete('photos', [APIControllers\RecipePhotoUploadController::class, 'deletePhotos'])
        ->middleware(['user.recipe'])
    ;

    // api/{recipe}/photos
    Route::get('photos', [APIControllers\RecipePhotoUploadController::class, 'getRecipePhotos'])
        ->middleware(['user.recipe']);
});

/**
 * Routes to handle photo upload when creating new recipe
 */
Route::middleware(['throttle:15,2', 'auth:sanctum'])
    ->prefix('recipe/create')
    ->group(function()
{
    // api/recipe/create/{uuid}/photos
    Route::post('{uuid}/photos', [APIControllers\RecipePhotoUploadController::class, 'cachePhotos']);

    // api/recipe/create/{uuid}/photos
    Route::delete('{uuid}/photos', [APIControllers\RecipePhotoUploadController::class, 'deleteCachedPhoto']);
});

Route::patterns([
    'uuid' => '^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$',
]);
