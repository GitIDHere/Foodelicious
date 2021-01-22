<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    
    
    
    
    
    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        // Create a User Service class
        // Check if the user is active
        // Send email to reset password
        // Signed URL
        // Confirm password before submitting form
        // Log that a password reset request was requested
        // Show message if user not found
        
        $email = $request->get('email');
        
        // Check if a user exists for the email supplied
        $user = User::where('email', '=', $email)->first();
        
        if ($user)
        {
            // Create a function in Users to get the username from UserProfile
            $passwordResetEmail = new PasswordReset();
            Mail::to($request->user())->send($passwordResetEmail);
        }
        else {
            // Show error
        }

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
