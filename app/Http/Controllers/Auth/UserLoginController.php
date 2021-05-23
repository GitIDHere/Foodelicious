<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $rememberMe = $request->get('remember_me');

        if (Auth::attempt($request->only('email', 'password'), $rememberMe))
        {
            $request->session()->regenerate();

            UserLogin::dispatch(Auth::user());

            return redirect()->route('home');
        }
        else {
            return back()->withErrors(['error.login' => 'Invalid email or password. Please try again.']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

}
