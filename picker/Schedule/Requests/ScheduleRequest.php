<?php

namespace Picker\Schedule\Requests;

use Picker\Schedule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'time'   => 'required|string|date_format:h:i A',
            'days' => ['required', 'array', Rule::in(array_keys(days()))],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->timeslotConflict()) {
                $validator->errors()
                          ->add('conflict', trans('messages.schedule.conflict'));
            }
        });
    }

    /**
     * Check if there is schedule occupying this time slot
     *
     * @return bool
     */
    public function timeslotConflict() : bool
    {
        $existing = $this->schedule;

        $newSchedule = new Schedule([
            'time' => $this->input('time'),
            'days' => $this->input('days', []),
        ]);

        return Schedule::timeslotConflict($existing ?? $newSchedule);
    }
}
