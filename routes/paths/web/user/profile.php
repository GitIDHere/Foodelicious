<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}')
    ->middleware(['user.verified', 'auth', 'url.parameters', 'user.routes'])
    ->group(function() 
    {
        Route::get('', [Controllers\UserProfileController::class, 'showProfile'])
        ->name('user.profile.view');
    })
;
