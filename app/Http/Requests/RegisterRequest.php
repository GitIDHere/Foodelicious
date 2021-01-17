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
            'password.required' => 'Password required',
            'password.confirmed' => 'Please make sure the confirmation password matched your password.',
        ];
    }
}
