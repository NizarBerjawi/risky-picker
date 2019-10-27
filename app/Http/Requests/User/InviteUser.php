<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class InviteUser extends UserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function($query) {
                    return $query->where('deleted_at', null);
                }),
            ],
        ];
    }
}
