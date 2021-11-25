<?php

namespace App\Http\Requests;

use http\Client\Request;
use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
//    public function __construct()
//    {
//        dd(\request('thumbnail'));
//    }
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
            // bail will stop validation if one of rules doesn't comply
            'title' => 'bail|required|max:100|min:5',
            'contents' => 'required|min:5',
            'thumbnail' => 'image|mimes:jpg,jpeg,png|max:8192|dimensions:min_height:500'
        ];
    }
}
