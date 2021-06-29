<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}')
    ->middleware(['auth', 'url.parameters', 'user.routes'])
    ->group(function()
    {
        /**
         * Show the profile page
         */
        Route::get('', [Controllers\UserProfileController::class, 'showProfile'])
            ->name('user.profile.view')
        ;

        /**
         * Show the form to update the profile details
         */
        Route::get('details', [Controllers\UserProfileController::class, 'showProfileUpdate'])
            ->name('user.profile.details')
        ;

        /**
         * Handle the form submission for updating the profile details
         */
        Route::post('details/update', [Controllers\UserProfileController::class, 'updateProfileDetails'])
            ->name('user.profile.details.update')
        ;
    })
;

Route::prefix('{username}')
    ->group(function()
    {
        Route::get('public/recipes', [Controllers\UserProfileController::class, 'showPublicRecipeList'])
            ->name('user.profile.public.recipe_list')
        ;
    });
