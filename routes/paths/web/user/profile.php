<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}')
    ->middleware(['auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        /*
         * Show a list of recipe belonging to the user
         */
        Route::get('', [Controllers\UserRecipeController::class, 'showRecipeList'])
            ->name('user.profile.view')
        ;
        
        Route::get('details', [Controllers\UserProfileController::class, 'showProfileDetails'])
            ->name('user.profile.details')
        ;
    
        Route::post('details/update', [Controllers\UserProfileController::class, 'updateProfileDetails'])
            ->name('user.profile.details.update')
        ;
        
    })
;
