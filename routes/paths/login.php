<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;





Route::get('/login', [Controllers\UserLoginController::class, 'show'])
    ->name('login.show')
;

Route::get('/logout', [Controllers\UserLoginController::class, 'logout'])
    ->name('logout');
    














