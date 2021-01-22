<?php

namespace App\Services;

use App\Models\User;

class UserProfileService
{
    
    
    /**
     * @param User $user
     * @param $username
     * @param array $profileInfo
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function createUserProfile(User $user, $username, $profileInfo = [])
    {
        if ($user instanceof User == false) {
            throw new \Exception('Invalid user');
        }
        
        /**
         * Username has to be present. But because we are using ->create() we need an array.
         * That is why we are merging the username array with the array from function parameter 
         */
        $profile = array_merge(['username' => $username], $profileInfo );
        return $user->userProfile()->create($profile);
    }
    
    
}
