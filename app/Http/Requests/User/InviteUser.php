<?php

namespace App\Http\Requests\User;

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
            'email' => 'required|email|unique:users,email|max:255',
        ];
    }
}
