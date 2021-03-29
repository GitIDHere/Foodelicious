<?php namespace App\Http\Controllers\User;

use App\Events\EmailUpdateEvent;
use App\Events\PasswordUpdateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEmailUpdateRequest;
use App\Http\Requests\UserPasswordChangedEvent;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSecurityController extends Controller
{
    private $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Handle the request to update the user's email address
     * 
     * @param UserEmailUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(UserEmailUpdateRequest $request)
    {
        $params = $request->all();
        $user = Auth::user();
        $currentEmail = $user->email;
        
        $user->email = $params['new_email'];
        $user->email_verified_at = null;
        $user->save();
    
        $user->sendEmailVerificationNotification();
    
        event(new EmailUpdateEvent($user, $currentEmail));
    
        return back()->with('message', 'Email updated. Please verify your new email.');
    }
    
    
    /**
     * @param UserPasswordChangedEvent $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UserPasswordChangedEvent $request)
    {
        $params = $request->all();
        $user = Auth::user();
    
        $newPassword = $params['new_password'];
        
        $user->forceFill([
            'password' => Hash::make($newPassword)
        ])->save();
        
        // Send email to user
        event(new PasswordUpdateEvent($user));
        
        return back()->with('message', 'Your password has been updated');
    }
    
}