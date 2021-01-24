<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;





Route::get('/login', function(){
    return view('screens.auth.login');    
})
->middleware(['guest'])
->name('login.show')
;

Route::get('/logout', [Controllers\UserLoginController::class, 'logout'])
    ->name('logout');
    














