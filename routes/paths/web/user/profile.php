<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as Controllers;

Route::prefix('profile/{username}')
    ->middleware(['user.verified', 'auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        Route::get('', [Controllers\User\UserProfileController::class, 'showProfile'])
        ->name('user.profile.view');
    })
;
