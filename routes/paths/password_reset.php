<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;


Route::get('/password-reset', function(){
    return view('screens.reset_password');
})
->middleware(['guest'])
->name('password_reset.show');



Route::post('/password-reset', [Controllers\PasswordResetController::class, 'sendPasswordResetEmail'])
->middleware(['throttle:5,1'])
->name('password_reset.submit')
;
