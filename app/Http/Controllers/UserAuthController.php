<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService;

class UserAuthController extends Controller
{
    
    private $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    

    
    public function register(RegisterRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        
        // Send confirmation email
        // Log them in when they confirm their email
        // Remember user
        // XX Hash password
        
        try {
            $user = $this->userService->register($email, $password);
            
            return redirect()->route('register.confirmation');
        } 
        catch(\Exception $exception) {
            return back()->withInput();
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
