<?php

namespace App\Http\Requests\Coffee;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CoffeeRequest extends FormRequest
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
            'start_time' => 'required|string',
            'end_time' => 'required|string',
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
                $validator->errors()->add('end_time', 'The end time should be after the start time.');
            }
        });
    }

    /**
     * Check that the start time is always before the end time
     *
     * @return bool
     */
    public function invalidTimeRange()
    {
        $startTime = Carbon::parse($this->input('start_time'));
        $endTime = Carbon::parse($this->input('end_time'));

        return $startTime->gte($endTime);
    }
}
