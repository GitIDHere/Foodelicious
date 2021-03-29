<?php namespace App\Http\Controllers\User;

use App\Events\EmailUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSecurityEmailRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

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
     * @param UserSecurityEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(UserSecurityEmailRequest $request)
    {
        $params = $request->all();
        $user = Auth::user();
        $currentEmail = $user->email;
        
        $user->email = $params['new_email'];
        $user->email_verified_at = null;
        $user->save();
    
        $user->sendEmailVerificationNotification();
    
        event(new EmailUpdateRequest($user, $currentEmail));
    
        return back()->with('message', 'Email updated. Please verify your new email.');
    }
    
    
}