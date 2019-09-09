<?php

namespace App\Http\Requests\UserCoffee;

use Carbon\Carbon;
use App\Models\UserCoffee;
use App\Rules\{CoffeeTimeConflict, ValidTimeRange};
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
     * 
     * @param  \Illuminate\Http\Request  $request
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
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // Adhoc coffees do not have a time range or day
        if ($this->adhoc) { return; }

        $validator->after(function ($validator) {
            if (! $this->validTimeRange()->passes()) {
                $validator->errors()
                          ->add('end_time', $this->validTimeRange()->message());
            }

            if (!$this->timeslotConflict()->passes()) {
                $validator->errors()
                          ->add('conflict', $this->timeslotConflict()->message());
            }
        });
    }

    /**
     * Check that the start time is always before the end time
     *
     * @return  \App\Rues\ValidTimeRange
     */
    public function validTimeRange()
    {
        return new ValidTimeRange(
            $this->input('start_time'), $this->input('end_time')
        );
    }

    /**
     * Check if there is another coffee occupying this
     * time slot
     *
     * @return TimeslotConflict
     */
    public function timeslotConflict()
    {
        // If a user is bound to the route, then an admin
        // is either updating or creating a coffee for
        // another user.
        $user = $this->user ?? $this->user();

        // If no coffee is bound to the route, then a user
        // is creating a new coffee
        if (! ($coffee = $this->userCoffee)) {
            $coffee = new UserCoffee();
            $coffee->user()->associate($user);
        }

        $coffee->fill($this->all());

        return new CoffeeTimeConflict($coffee);
    }
}
