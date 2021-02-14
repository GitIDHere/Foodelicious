<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserRegisterController extends Controller
{
    
    /**
     * @var UserRegisterService 
     */
    private $userRegisterService;
    
    
    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
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
        $user = Auth::user();
        
        if ($user && $user->hasVerifiedEmail()) {
            return Redirect::route('home');
        }
        else {
            return view('screens.auth.register.register_confirmation');
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
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $rememberMe = $request->get('remember_me') ? true : false;
        
        $user = $this->userRegisterService->registerUser($email, $password, $username);
        
        if ($user instanceof User)
        {
            //Auth::login($user, $rememberMe);
            return Redirect::route('register.confirmation');
        }
        else {
            return back()->withInput();   
        }
    }
    
    
    
}
