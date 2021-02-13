<?php

use Illuminate\Support\Facades\Route;



Route::get('/404', function(){
    return view('screens.general.404');
})->name('404_page');