<?php

namespace App\Http\Controllers\Auth;

use App\Classes\AppResponse;
use App\Events\UserLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

            return AppResponse::getResponse($request, [], 302, '', 'home');
        }
        else {
            return AppResponse::getErrorResponse($request, ['error.login' => 'Invalid email or password. Please try again.']);
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

        return AppResponse::getResponse($request, [], 302);
    }

}
