<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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

    public function messages()
    {
        return [
            'locale.in' => 'Language is not supported.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'avatar' => 'image|mimes:jpg,jpeg,png,svg,gif|max:8192|dimensions:min_height:500',
            'locale' =>[
                'required',
                Rule::in(array_keys(User::LOCALES))
            ]
        ];
    }
}
