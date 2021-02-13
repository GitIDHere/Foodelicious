<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth as Controllers;



Route::get('/404', function(){
    return view('screens.general.404');
})->name('page_404');