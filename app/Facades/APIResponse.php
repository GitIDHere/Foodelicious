<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\Response make($code, $content)
 *
 * @see \App\Classes\APIResponse
 */
class APIResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Classes\APIResponse::class;
    }
}