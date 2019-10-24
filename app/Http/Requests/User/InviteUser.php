<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Validation\Validator;

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
            'email' => 'required|email|max:255|unique:users,email,null,null,deleted_at,null',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->isNotUnique()) {
                $validator->errors()->add('name', trans('messages.user.duplicate'));
            }
        });
    }

    /**
     * We check if the email exists in the database. We only look
     * through users that have not been soft-deleted.
     *
     * @return bool
     */
    public function isNotUnique()
    {
        return User::where('email', $this->input('email'))->exists();
    }
}
