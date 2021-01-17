<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserLoginController extends Controller
{
    public function __construct()
    {
        
    }
    
    /**
     * Method: GET
     * 
     * Show the login form
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show()
    {
        // Do not show the login page if the user is already logged in
        if (Auth::check() == false) {
            return view('screens.login');    
        } else {
            return Redirect::route('home');
        }
    }
    
    
    /**
     * Method: GET
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    
}
