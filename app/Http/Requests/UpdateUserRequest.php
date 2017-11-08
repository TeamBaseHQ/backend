<?php

namespace Base\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => "bail|min:4|max:255",
            'email' => [
                "bail",
                "email",
                Rule::unique('users')->ignore(request()->user()->id)
            ],
            'password' => 'bail|confirmed',
        ];
    }
}
