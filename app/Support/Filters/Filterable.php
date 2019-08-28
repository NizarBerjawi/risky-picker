<?php

namespace App\Support\Filters;

use Builder;

trait Filterable
{
    /**
     * Scope a query to apply given filter.
     *
     * @param Builder $query
     * @param Filter $filter
     * @return Builder
     */
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }
}
