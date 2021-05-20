<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:20|min:3|unique:user_profiles,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|bail|max:25|min:3|confirmed',
            'password_confirmation ' => 'max:25|min:3',
            'remember_me' => 'nullable|boolean',
        ];
    }
    
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'remember_me.boolean' => 'Invalid value for remember me',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Please make sure the confirmation password matched your password.',
        ];
    }
}
