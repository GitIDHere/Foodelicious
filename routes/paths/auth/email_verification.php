<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;

/**
 * Route to verify the user's email address after they click on the verify link
 */
Route::get('/email/verify/{id}/{hash}', [Controllers\EmailVerificationController::class, 'handleVerifyEmail'])
    // signed middleware = Prevent URL manipulation by attaching a hash to the URL
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');


/**
 * Send a verification email to user
 */
Route::post('/email/send-verification', [Controllers\EmailVerificationController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');



