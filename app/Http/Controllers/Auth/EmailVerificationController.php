<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmailVerificationController
{
    /**
     * Handle the request to verify the user's email. This will redirect the user to homepage when successful
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleVerifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return Redirect::route('verification.confirmation');
    }


    /**
     * Send verification email
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent. Please check your email');
    }

}
