<?php

namespace Picker\UserCoffee\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserCoffeeRequest extends FormRequest
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
            'sugar' => 'required|integer',
            'start_time' => 'required|string|date_format:h:i A',
            'end_time' => 'required|string|date_format:h:i A',
            'days' => ['required', 'array', Rule::in(['mon', 'tue', 'wed', 'thu', 'fri'])]
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
            if ($this->invalidTimeRange()) {
                $validator->errors()
                          ->add('end_time', trans('messages.coffee.invalid'));
            }

            if ($this->timeslotConflict()) {
                $validator->errors()
                          ->add('conflict', trans('messages.coffee.conflict'));
            }
        });
    }

    /**
     * Check that the start time is always before the end time
     *
     * @return bool
     */
    public function invalidTimeRange() : bool
    {
        $startTime = Carbon::parse($this->input('start_time'));
        $endTime = Carbon::parse($this->input('end_time'));

        return $startTime->gte($endTime);
    }

    /**
     * Check if there is another coffee by this user
     * occupying this time slot
     *
     * @return bool
     */
    public function timeslotConflict() : bool
    {
        return $this->user()
                    ->userCoffees()
                    ->exclude([$this->userCoffee])
                    ->between($this->input('start_time'), $this->input('end_time'))
                    ->days($this->input('days'))
                    ->exists();
    }
}
