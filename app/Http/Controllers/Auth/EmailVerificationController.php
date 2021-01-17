<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmailVerificationController
{
    
    
    
    public function __construct()
    {
        
    }
    
    
    /**
     * Method: GET
     *
     * Handle the request to verify the user's email. This will redirect the user to homepage when successful
     *
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleVerifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        /**
         * TODO - Flash success message at the top in the view that they get redirected to
         */
        return Redirect::route('home');
    }
    
    
    /**
     * Method: POST
     *
     * Send verification email
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
    
}
