<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User as Controllers;

Route::prefix('{username}/account-security')
    ->middleware(['auth', 'url.parameters', 'user.routes'])
    ->group(function()
    {
        /**
         * Show a list of options available for the user
         */
        Route::get('', function(){
            return view('screens.user.security.list');
        })
            ->name('user.security.view')
        ;

        /**
         * Show a form for the user to update their email
         */
        Route::get('email', function(){
            return view('screens.user.security.email');
        })
            ->name('user.security.email.view')
        ;

        /**
         * Handle the request for updating a user's email
         */
        Route::post('email', [Controllers\UserSecurityController::class, 'updateEmail'])
            ->middleware(['user.verified'])
            ->name('user.security.email.submit')
        ;

        /**
         * Show page to update password
         */
        Route::get('password', function(){
            return view('screens.user.security.password');
        })
            ->name('user.security.password.view')
        ;

        /**
         * Handle request to update password
         */
        Route::post('password', [Controllers\UserSecurityController::class, 'updatePassword'])
            ->middleware(['user.verified'])
            ->name('user.security.password.submit')
        ;

    })
;
