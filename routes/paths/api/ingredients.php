<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API as APIControllers;


/**
 * Get a list of ingredients matching the term
 */
Route::post('ingredient', [APIControllers\APIIngredientsController::class, 'getList'])
    ->middleware(['throttle:50,1'])
;
