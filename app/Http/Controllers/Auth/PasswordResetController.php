<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PasswordResetController extends Controller
{
    
    
    
    
    public function show()
    {
        if (Auth::check()) {
            return Redirect::route('home');
        }
        else {
            return view('screens.reset_password');
        }
    }
    
    
    public function resetPassword()
    {
        // Check if the user is active
        // Send email to reset password
        // Signed URL
        // Confirm password before submitting form
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
