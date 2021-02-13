<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserRoutes
{
    /**
     * Check if the user trying to access a path with a username prefix belongs to the Auth::user
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $failed = true;
        
        $user = Auth::user();
        $userProfile = $user->userProfile;
        
        if ($userProfile && $request->route()->hasParameter('username')) 
        {
            $urlUsername = $request->route()->parameter('username');
            if ($urlUsername === $userProfile->username) {
                $failed = false;
            }
        }
        
        if ($failed) {
            return redirect()->route('home');
        }
        
        return $next($request);
    }
}
