<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;


Route::get('/', [Controllers\HomeController::class, 'showHome'])
    ->name('home');

Route::get('/home', [Controllers\HomeController::class, 'showHome'])
    ->name('home');

