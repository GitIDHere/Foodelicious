<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}/recipe/favourites')
    ->middleware(['auth', 'url.parameters', 'user.routes'])
    ->group(function()
    {
        /**
         * Show the favourite recipe list
         */
        Route::get('', [Controllers\UserFavouriteRecipeController::class, 'showFavouriteList'])
            ->name('user.recipe.favourites')
        ;

        /*
         * Search for a favourited recipe
         */
        Route::post('recipes/search', [Controllers\UserFavouriteRecipeController::class, 'searchFavouriteRecipe'])
            ->name('user.recipe.favourites.search.submit')
        ;
    })
;
