<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\{User, UserCoffee};
use Illuminate\Contracts\Validation\Rule;

class ValidTimeRange implements Rule
{
    /**
     * The start date
     *
     * @var Carbon
     */
    protected $start;

    /**
     * The end date
     *
     * @var Carbon
     */
    protected $end;

    /**
     * Create a new rule instance.
     *
     * @param string $start
     * @param string $end
     * @return void
     */
    public function __construct($start, $end)
    {
        $this->start = Carbon::parse(date("G:i", strtotime($start)));
        $this->end = Carbon::parse(date("G:i", strtotime($end)));
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
        return $this->start->lt($this->end);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('messages.coffee.invalid');
    }
}
