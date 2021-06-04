<?php

namespace App\Http\Controllers\User;

use App\Events\UserProfileDetailsUpdates;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileDetailsRequest;
use App\Models\File;
use App\Models\User;
use App\Services\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    /**
     * @var UserProfileService
     */
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
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->userProfile;

        $profilePic = $profile->files->first();

        $profileData = [
            'description' => $profile->description,
            'short_description' => $profile->short_description,
            'img' => (is_object($profilePic) ? asset($profilePic->public_path) : '')
        ];

        return view('screens.user.profile.view')->with('data', $profileData);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProfileUpdate(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->userProfile;

        $details = ['description' => $profile->description];

        $profilePic = $profile->files->first();
        if(is_object($profilePic)) {
            $details['profile_pic_path'] = asset($profilePic->public_path);
        }

        return view('screens.user.profile.update_details')->with('details', $details);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfileDetails(ProfileDetailsRequest $request)
    {
        $formData = $request->all();

        /** @var User $user */
        $user = Auth::user();
        $userProfile = $user->userProfile;

        $this->profileService->updateDescription($userProfile, $formData['description']);

        if (isset($formData['profile_pic']) && !empty($formData['profile_pic']))
        {
            $profilePicData = [
                'image' => $formData['profile_pic'],
                'crop_x' => $formData['img-x'],
                'crop_y' => $formData['img-y'],
                'crop_w' => $formData['img-w'],
                'crop_h' => $formData['img-h'],
            ];

            // Remove the existing profile pic
            $this->profileService->removeProfilePic($userProfile);

            $profilePicFile = $this->profileService->setProfilePic($profilePicData);

            // Not sure if the file gets saved or if ->save needs to be called
            $userProfile->files()->attach($profilePicFile);
        }

        // Send out an event
        UserProfileDetailsUpdates::dispatch($userProfile);

        return redirect()->route('user.profile.view');
    }

}
