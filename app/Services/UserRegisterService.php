<?php

namespace App\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserRegisterService
{
    /**
     * @var UserService
     */
    private $userService;
    
    /**
     * @var UserProfileService
     */
    private $userProfileService;
    
    
    public function __construct(UserService $userService, UserProfileService $userProfileService)
    {
        $this->userService = $userService;
        $this->userProfileService = $userProfileService;
    }
    
    
    /**
     * @param $email
     * @param $password
     * @param $username
     * @return mixed|null
     */
    public function registerUser($email, $password, $username)
    {
        try {
        
            DB::beginTransaction();
        
            $user = $this->userService->register($email, $password);
            $this->userProfileService->createUserProfile($user, $username);
        
            // Dispatch event to send verification email
            event(new Registered($user));
            
            DB::commit();
            
            return $user;
        }
        catch(\Exception $exception) {
            DB::rollBack();
        }
        
        return null;
    }
    
    
}
