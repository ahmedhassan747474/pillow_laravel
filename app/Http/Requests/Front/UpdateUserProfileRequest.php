<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
        // dd(auth()->user()->email);
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'password' => 'nullable',
        ];
    }
}
