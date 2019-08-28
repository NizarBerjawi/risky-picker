<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ExcludesFromQuery
{
    /**
     * Exclude a from the query
     *
     * @param Builder $query
     * @param array $users
     * @return Builder
     */
     public function scopeExclude(Builder $query, array $items) : Builder
     {
         $exclude = array_map(
             function($item) {
                 if ($item instanceof static) {
                     return $item->getAttribute($item->getKeyName());
                 }

                 return $item;
             }, array_filter($items));

         return $query->whereNotIn($this->getKeyName(), $exclude);
     }
}
