<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

abstract class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'cup_photo' => 'sometimes|file',
        ];
    }
}
