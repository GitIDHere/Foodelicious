<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;


Route::get('/forgot-password', function(){
    return view('screens.auth.password.forgot_password');
})
->middleware(['guest'])
->name('forgot_password.show');


Route::post('/forgot-password', [Controllers\PasswordResetController::class, 'sendPasswordResetEmail'])
->middleware(['guest', 'throttle:5,1'])
->name('forgot_password.submit');


Route::get('/password-reset/{token}/{email}', [Controllers\PasswordResetController::class, 'showPasswordResetForm'])
->middleware(['guest'])
->name('password_reset.show');


Route::post('/password-reset', [Controllers\PasswordResetController::class, 'resetPassword'])
->middleware(['guest'])
->name('password_reset.submit')
;
