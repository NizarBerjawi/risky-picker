<?php

namespace App\Filters;

use App\Models\Coffee;
use App\Support\Filters\Filter;

class UserCoffeeFilters extends Filter
{
    /**
     * Filter by  coffee types.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function coffeeType()
    {
        $coffee = Coffee::withTrashed()->whereSlug($this->request->get('coffee_type'));

        if (!$coffee->exists()) { return $this->builder; }

        return $this->builder->withTrashed()->byType($coffee->first());
    }
}
