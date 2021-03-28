<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    
    public function showProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->userProfile;
                
        return view('screens.user.profile.view')->with('profile', $profile);
    }
}
