<?php

namespace App\Http\Controllers\User;

use App\Events\UserProfileDetailsUpdates;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileDetailsRequest;
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
    public function profileUpdate(Request $request)
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
    public function updateProfileDetails(ProfileDetailsRequest $request)
    {
        $formData = $request->all();

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

            $profilePicFile = $this->profileService->setProfilePic( $profilePicData);

            // Not sure if the file gets saved or if ->save needs to be called
            $userProfile->files()->attach($profilePicFile);
        }

        // Send out an event
        UserProfileDetailsUpdates::dispatch($userProfile);

        return redirect()->route('user.profile.view');
    }






}
