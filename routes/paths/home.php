<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;


Route::get('/', function () {
    return view('screens.home');
})->name('home');



