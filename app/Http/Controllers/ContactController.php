<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function showContact(Request $request)
    {
        $email = '';

        $user = Auth::user();
        if ($user) {
            $email = $user->email;
        }

        return view('screens.contact')->with('email', $email);
    }

}
