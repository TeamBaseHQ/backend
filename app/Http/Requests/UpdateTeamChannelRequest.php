<?php

namespace Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamChannelRequest extends FormRequest
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
            "name" => "bail|max:255",
            "is_private" => "bail|boolean",
            "description" => "bail|max:255",
            "color" => "bail|max:10",
        ];
    }
}
