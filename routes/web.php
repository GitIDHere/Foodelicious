<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;

Route::get('/', [Controllers\HomeController::class, 'showHome'])
    ->name('home');

Route::get('contact', [Controllers\ContactController::class, 'showContact'])
    ->name('contact');

Route::get('/404', function(){
    return view('screens.general.404');
})->name('404_page');
