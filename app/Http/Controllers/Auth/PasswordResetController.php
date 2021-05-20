<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\PasswordResetService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    
    private $passwordResetService;
    
    
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }
    
    
    /**
     * Method: POST
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        $email = $request->only('email');
        
        Password::sendResetLink($email);
        
        // Returning a success always because we don't want
        // user to know if email exists in DB or not  
        return back()->with(['message' => 'Email sent']);
    }
    
    
    /**
     * Method: GET
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPasswordResetForm(Request $request, $token, $email)
    {
        // Check if the token has expired
        $isTokenValid = $this->passwordResetService->isTokenValid($token, $email);
                
        if ($isTokenValid)
        {
            return view('screens.auth.password.password_reset', [
                'token' => $token,
                'email' => $email
            ]);   
        } else {
            return redirect()
                ->route('forgot_password.show')
                ->withErrors('Password request token has expired');
        }
    }
    
    
    /**
     * Method: POST
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3|max:25|confirmed' 
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) 
            {
                // Set the new password. Using `forceFill()` because `password` is mass assignment protected
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            
                $user->setRememberToken(Str::random(60));
            
                event(new PasswordReset($user));
            }
        );
    
        if ($status == Password::PASSWORD_RESET)
        {
            return redirect()->route('login.show')->with('message', 'Password reset successfully');
        } else {
            return back()->withErrors('Invalid request');   
        }
    }
    
    
}
