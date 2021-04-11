<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    private $profileService;
    
    
    public function __construct(UserProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->userProfile;
        return view('screens.user.profile.view')->with('profile', $profile);
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProfileUpdate(Request $request)
    {
        $user = Auth::user();

        $profile = $user->userProfile;

        $details = [
            'description' => $profile->description
        ];
        
        return view('screens.user.profile.update_details')->with('details', $details);
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfileDetails(Request $request)
    {
        $validated = $request->validate([
            //'photo' => 'required|mimes:jpg,png,bmp',
            'description' => 'nullable|string|max:850'
        ]);
        
        $user = Auth::user();
        
        $profileInfo = $request->all();
        
        $info = [
            'description' => $profileInfo['description'] 
        ];
        
        $this->profileService->updateDetails($user, $info);
        
        return redirect()->route('user.profile.view');
    }
    
    
    
    
    
    
}
