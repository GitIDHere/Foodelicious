<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;

class UserProfileService
{
    private $profilePhotoService;
    
    public function __construct(ProfilePhotoService $profilePhotoService)
    {
        $this->profilePhotoService = $profilePhotoService;
    }
    
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
    
    
    /**
     * @param User $user
     * @param string $description
     * @return bool
     */
    public function updateDescription($user, $description)
    {
        $profile = $user->userProfile();
        
        if ($profile instanceof UserProfile) 
        {
            $profile->update(['description' => $description]);
        }
                
        return true;
    }
    
    
    /**
     * @param $user
     * @param array $imageData
     */
    public function setProfilePic($user, $imageData = [])
    {
        if($user instanceof User && !empty($imageData))
        {
            $uploadedImg = $imageData['image'];
    
            $imgW = $imageData['crop_w'];
            $imgH = $imageData['crop_h'];
            $imgX = $imageData['crop_x'];
            $imgY = $imageData['crop_y'];
    
            $driver = Storage::drive(PhotoService::VISIBILITY_PUBLIC);
            $this->profilePhotoService->setDriver($driver);
            $imagePath = $this->profilePhotoService->cropImage($uploadedImg, $imgW, $imgH, $imgX, $imgY);
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
