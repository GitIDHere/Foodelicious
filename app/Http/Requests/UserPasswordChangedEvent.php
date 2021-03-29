<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserPasswordChangedEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|min:3|max:25|password:web',
            'new_password' => 'required|min:3|max:25|confirmed',
            'new_password_confirmation' => 'min:3|max:25',
        ];
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.password' => 'Incorrect current password',
            'password.confirmed' => 'New password did not match',
            'new_password.min' => 'New password is too short',
            'new_password.max' => 'New password is too long'
        ];
    }
}
