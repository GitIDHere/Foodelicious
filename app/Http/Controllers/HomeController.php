<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showHome(Request $request)
    {
        $username = '';
        $user = Auth::user();
        
        if ($user) {
            $username = $user->userProfile->username;
        }
        
        URL::defaults(['username' => $username]);
        
        return view('screens.home');
    }
    
    
}