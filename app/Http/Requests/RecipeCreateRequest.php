<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RecipeCreateRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:60',
            'description' => 'required|string|min:5|max:10000',
            'cooking_steps' => 'required|array',
            'cook_time_hours' => 'required|between:0,15',
            'cook_time_minutes' => 'required|numeric|between:1,59',
            'servings' => 'required|numeric|max:50',
            'utensils' => 'required|json',
            'prep_directions' => 'required|string|max:10000',
            'ingredients' => 'required|json',
            'photos' => 'nullable',
            'photos.*' => 'mimes:jpeg,jpg,png|max:2048',
            'delete_photos' => 'nullable',
            'delete_photos.*' => 'numeric|integer|distinct',
            'visibility' => 'required|string|'.Rule::in(['public', 'private']),
        ];
    }
}
