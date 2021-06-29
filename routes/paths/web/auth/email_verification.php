<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;

/**
 * Route to verify the user's email address after they click on the verify link
 */
Route::get('/email/verify/{id}/{hash}', [Controllers\EmailVerificationController::class, 'handleVerifyEmail'])
    // signed middleware = Prevent URL manipulation by attaching a hash to the URL
    ->middleware(['user.email.verify', 'signed'])
    ->name('verification.verify')
;

/**
 * Send a verification email to user
 */
Route::post('/email/verify/send-verification', [Controllers\EmailVerificationController::class, 'sendVerificationEmail'])
    ->middleware(['user.email.verify', 'throttle:6,1'])
    ->name('verification.send')
;

/**
 * Show a confirmation for verifying the email
 */
Route::get('/email/verify/confirmation', function(){
        return view('screens.auth.verify.email_confirmation');
    })
    ->middleware(['auth', 'user.email.verify'])
    ->name('verification.confirmation')
;

/**
 * Show prompt to verify email
 */
Route::get('/email/verify/prompt', function(){
        return view('screens.auth.verify.prompt_verification');
    })
    ->middleware(['auth', 'user.email.verify'])
    ->name('verification.prompt')
;
