<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class URLParameters
{
    /**
     * Set any URL parameters for the route
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $username = '';

        /** @var User $user */
        $user = Auth::user();

        if ($user) {
            $username = $user->userProfile->username;
        }

        URL::defaults(['username' => $username]);

        return $next($request);
    }
}
