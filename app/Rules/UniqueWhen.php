<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueWhen implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(closure $closure)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
