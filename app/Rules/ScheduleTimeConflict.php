<?php

namespace App\Rules;

use App\Models\Schedule;
use Illuminate\Contracts\Validation\Rule;

class ScheduleTimeConflict implements Rule
{
    /**
     * The schedule that we are testing against the rule
     *
     * @var  \App\Models\Schedule  $schedule
     */
    protected $schedule;

    /**
     * Create a new rule instance.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
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
        return Schedule::query()
            ->at($this->schedule->time)
            ->days($this->schedule->days ?? [])
            ->when($this->schedule->exists, function($query) {
                $query->exclude([$this->schedule]);
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
        return trans('messages.schedule.conflict');
    }
}
