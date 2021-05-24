<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileDetailsRequest extends FormRequest
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
            'profile_pic' => 'nullable|mimes:jpeg,jpg,png,bmp|max:2048',
            'img-x' => 'nullable|required_with:new_profile_pic|integer',
            'img-y' => 'nullable|required_with:new_profile_pic|integer',
            'img-w' => 'nullable|required_with:new_profile_pic|integer',
            'img-h' => 'nullable|required_with:new_profile_pic|integer',
            'description' => 'nullable|string|max:850'
        ];
    }
}
