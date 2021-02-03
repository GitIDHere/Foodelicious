<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;


Route::get('/', function () {
    return view('screens.home');
})->name('home');

Route::get('/home', function () {
    return view('screens.home');
})->name('home');

