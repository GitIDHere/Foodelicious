<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserEmailUpdateRequest extends FormRequest
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
            'password' => 'required|max:25|min:3|password:web',
            'new_email' => 'required|confirmed|unique:users,email|email',
            'new_email_confirmation' => 'email'
        ];
    }
    
    function messages()
    {
        return [
            'new_email.unique' => 'The new email address is taken. Please use a different email.',
        ];
    }
}
