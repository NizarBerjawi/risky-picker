<?php

namespace App\Http\Requests\Coffee;

use App\Models\Coffee;
use Cocur\Slugify\Slugify;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

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
            'description' => 'sometimes|nullable|string|max:255',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->duplicateCoffee()) {
                $validator->errors()->add('name', trans('messages.coffee.duplicate'));
            }
        });
    }

    /**
     * Check if the coffee type the user is trying to
     * create has already been created.
     *
     * @return bool
     */
    public function duplicateCoffee()
    {
        $engine = new Slugify();
        $service = new SlugService();

        $separator = array_get('separator', $service->getConfiguration());
        $slug = $engine->slugify($this->input('name'), $separator);

        return Coffee::where((new Coffee)->getSlugKeyName(), 'LIKE', "%$slug%")
                     ->when(!$this->isMethod('POST'), function($query) {
                        $query->where('id', '!=', $this->coffee->id);
                     })
                     ->exists();
    }
}
