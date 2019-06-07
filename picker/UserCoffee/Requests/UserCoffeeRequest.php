<?php

namespace Picker\UserCoffee\Requests;

use Carbon\Carbon;
use Picker\UserCoffee;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserCoffeeRequest extends FormRequest
{
    /**
     * Instantiate the Form Request
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->adhoc = $request->get('is_adhoc', false);
    }
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
        return array_merge([
            'name' => 'required|string|max:255',
            'sugar' => 'required|integer',
        ], !$this->adhoc ? [
            'start_time' => 'required|string|date_format:h:i A',
            'end_time' => 'required|string|date_format:h:i A',
            'days' => [
              'required', 'array', Rule::in([
                'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'
              ])]
        ] : []);
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // Adhoc coffees do not have a time range or day
        if ($this->adhoc) { return; }

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
        return UserCoffee::validateTimeRange(
            $this->input('start_time'), $this->input('end_time')
        );
    }

    /**
     * Check if there is another coffee by this user
     * occupying this time slot
     *
     * @return bool
     */
    public function timeslotConflict() : bool
    {
        $existing = $this->userCoffee;

        $newCoffee = new UserCoffee([
            'start_time' => $this->input('start_time'),
            'end_time' => $this->input('end_time'),
            'days' => $this->input('days'),
        ]);

        return UserCoffee::timeslotConflict($this->user(), $existing ?? $newCoffee);
    }
}
