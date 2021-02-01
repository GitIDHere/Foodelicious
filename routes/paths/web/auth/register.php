<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;

/**
 * Show the registration form
 */
Route::get('/register', function(){
    return view('screens.auth.register');
})
->middleware(['guest'])
->name('register.show');

/**
 * Handle the registration form POST request
 */
Route::post('/register', [Controllers\UserRegisterController::class, 'register'])
->name('register.submit');

/**
 * Show the user a confirmation screen after successful registration
 */
Route::get('/register/confirm', [Controllers\UserRegisterController::class, 'confirmation'])
->middleware(['auth'])
->name('verification.notice');
