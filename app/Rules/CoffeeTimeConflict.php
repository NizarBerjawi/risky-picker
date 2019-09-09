<?php

namespace App\Rules;

use App\Models\{User, UserCoffee};
use Illuminate\Contracts\Validation\Rule;

class CoffeeTimeConflict implements Rule
{
    /**
     * The user coffee that we are testing
     *
     * @var UserCoffee
     */
    protected $userCoffee;

    /**
     * Create a new rule instance.
     *
     * @param  \App\Models\UserCoffee  $userCoffee
     * @return void
     */
    public function __construct(UserCoffee $userCoffee)
    {
        $this->userCoffee = $userCoffee;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute = null, $value = null)
    {
        $coffee = $this->userCoffee;
        $user = $this->userCoffee->user;

        return $user->userCoffees()
                    ->withoutAdhoc()
                    ->between($coffee->start_time, $coffee->end_time)
                    ->days($coffee->days ?? [])
                    ->when($coffee->exists, function($query) use ($coffee){
                        $query->exclude([$coffee]);
                    })
                    ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('messages.coffee.conflict');
    }
}
