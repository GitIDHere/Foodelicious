<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'title' => 'required|string|min:3|max:250',
            'description' => 'required|string|min:10|max:10000',
            'directions' => 'required|json',
            'cook_time' => 'required|string|size:5',
            'servings' => 'required|numeric|max:50',
            'utensils' => 'required|json',
            'prep' => 'required|string|max:10000',
            'ingredients' => 'required|json',
        ];
    }
}
