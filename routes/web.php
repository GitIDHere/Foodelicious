<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;

Route::get('/', function () {
    return view('screens.home');
});

Route::get('/register', function(){
    return view('screens.register');
})->name('register');

Route::get('/register/confirm', function(){
    return view('screens.register_confirmation');
})->name('register.confirmation');

Route::post('/register', [Controllers\UserAuthController::class, 'register']);
