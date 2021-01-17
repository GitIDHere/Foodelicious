<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserRegisterController extends Controller
{
    private $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    /**
     * Method: GET
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showForm(Request $request)
    {
        if (Auth::check()) {
            return Redirect::route('home');
        }
        else {
            return view('screens.register');
        }
    }
    
    
    /**
     * Method: GET
     * 
     * Show the confirmation page to users who successfully registered.
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirmation(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::route('home');
        }
        else {
            return view('screens.register_confirmation');
        }
    }
    
    
    /**
     * Method: POST
     * 
     * Handle POST request for registering to the site
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $rememberMe = $request->get('remember_me') ? true : false;
        
        try {
            $user = $this->userService->register($email, $password);
            
            // Dispatch event to send verification email
            event(new Registered($user));
            
            Auth::login($user, $rememberMe);
            
            return Redirect::route('verification.notice');
        } 
        catch(\Exception $exception) {
            return back()->withInput();
        }
    }
    
    
    
}
