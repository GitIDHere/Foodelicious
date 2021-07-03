<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRecipe
{
    /**
     * Check if the recipe belongs to the user
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $hasRecipeRoute = $request->route()->hasParameter('recipe');

        $failed = true;

        if ($hasRecipeRoute)
        {
            $user = Auth::user();
            $userProfile = $user->userProfile;

            $recipe = $request->route()->parameter('recipe');

            if ($userProfile->recipes->contains($recipe->id))
            {
                $failed = false;
            }
        }

        if ($failed) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
