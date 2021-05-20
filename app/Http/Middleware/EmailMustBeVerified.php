<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class EmailMustBeVerified
{
    /**
     * Only allow users who have verified their email address to pass 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $failed = true;
        
        $user = Auth::user();
        
        if ($user && $user->hasVerifiedEmail()) {
            $failed = false;
        }
                
        // Only allow this middleware to access the email verification screen
        if ($user && $request->route()->named('verification.*')) {
            $failed = false;
        }
        
        if ($failed) 
        {
            // If the user is logged in then show them the prompt screen to verify their email
            if ($user) {
                return redirect()->route('verification.prompt');
            } 
            else {
                return redirect()->guest(route('login.show'));
            }
                        
        }
        
        return $next($request);
    }
}
