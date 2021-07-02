<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;

Route::get('/', function () {
    return view('screens.home');
})->name('home');


Route::get('/404', function(){
    return view('screens.general.404');
})->name('404_page');
