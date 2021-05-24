<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserRoute
{
    /**
     * Check if the user trying to access a path with a username prefix belongs to the authenticated user
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $failed = true;

        /** @var User $user */
        $user = Auth::user();
        $userProfile = $user->userProfile;

        // Check if the current route has the {username} parameter
        if ($userProfile && $request->route()->hasParameter('username'))
        {
            $urlUsername = $request->route()->parameter('username');

            // Check if the {username} parameter matches the authenticated user's username
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
