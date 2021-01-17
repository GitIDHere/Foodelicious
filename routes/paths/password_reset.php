<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;


Route::get('/password-reset', [Controllers\PasswordResetController::class, 'show'])
    ->name('password_reset.show');

Route::post('/password-reset', [Controllers\PasswordResetController::class, 'resetPassword'])
    ->middleware(['throttle:5,1'])
    ->name('password_reset.submit')
;
