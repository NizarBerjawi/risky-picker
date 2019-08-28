<?php

namespace App\Http\Requests\Schedule;

use App\Models\Schedule;
use App\Rules\{ScheduleTimeConflict};
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
            'time' => 'required|string|date_format:h:i A',
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
            if (!$this->timeslotConflict()->passes()) {
                $validator->errors()
                          ->add('conflict', $this->timeslotConflict()->message());
            }
        });
    }

    /**
     * Check if there is schedule occupying this time slot
     *
     * @return ScheduleTimeConflict
     */
    public function timeslotConflict()
    {
        $schedule = $this->schedule ?? new Schedule();

        $schedule->fill($this->all());

        return new ScheduleTimeConflict($schedule);
    }
}
