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
     * Determines whether this is a regular coffee
     * request or an adhoc coffee request
     *
     * @var boolean
     */
    protected $adhoc;

    /**
     * Initialize
     */
    public function __construct(Request $request)
    {
        $this->adhoc = $request->route('run') && $request->query('coffee_id');
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
            'coffee_id' => 'required|integer|exists:coffees,id',
            'sugar' => 'required|integer',
        ], !$this->adhoc ? [
            'start_time' => 'required|string|date_format:h:i A',
            'end_time' => 'required|string|date_format:h:i A',
            'days' => [
              'required', 'array', Rule::in(array_keys(days()))]
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
            if (!$this->validTimeRange()) {
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
    public function validTimeRange() : bool
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
            'days' => $this->input('days', []),
        ]);

        return UserCoffee::timeslotConflict($this->user(), $existing ?? $newCoffee);
    }
}
