<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\Response make($code, $content)
 *
 * @see \App\Classes\AppResponse
 */
class AppResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Classes\AppResponse::class;
    }
}
