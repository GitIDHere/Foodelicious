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
            $targetW = 500;
            $targetH = 500;
            
            $uploadedImg = $imageData['image'];
    
            $imgW = $imageData['crop_w'];
            $imgH = $imageData['crop_h'];
            $imgX = $imageData['crop_x'];
            $imgY = $imageData['crop_y'];
    
//            $scaleX = ($targetW / $imgW);
//            $scaleY = ($targetH / $imgH);
//            
//            if ($scaleX < $scaleY) {
//                # if the height needs to be scaled.
//                # shrink y to match x scale
//                $targetH = ($imgH * $scaleX);
//                $targetW = ($imgW * $scaleX);
//            } else {
//                # shrink y to match x scale
//                $targetH = ($imgH * $scaleY);
//                $targetW = ($imgW * $scaleY);
//            }
            
            $driver = Storage::drive(PhotoService::VISIBILITY_PUBLIC);
            $this->profilePhotoService->setDriver($driver);
            $this->profilePhotoService->cropImage($uploadedImg, $imgW, $imgH, $imgX, $imgY);
        }
        
        dd($imageData);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
