<?php

namespace Picker\Support\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDays
{
    public function getDaysField()
    {
        if (method_exists($this, 'daysColumn')) {
            return $this->daysColumn();
        }

        if (property_exists($this, 'daysColumn')) {
            return $this->daysColumn;
        }

        return 'days';
    }

    /**
     * Get all the schedule happening on certain days
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $days
     * @param bool $strict
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDays(Builder $query, array $days, bool $strict = false)
    {
        $boolean = $strict ? 'and' : 'or';

        $query->where(function($query) use ($days, $boolean) {
            foreach($days as $day) {
                $query->where($this->getDaysField(), 'LIKE', "%$day%", $boolean);
            }
        });

        return $query;
    }

    /**
     * Get all the schedules that are due to happen today
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday(Builder $query)
    {
        $today = Carbon::today();

        return $query->days([strtolower($today->shortEnglishDayOfWeek)]);
    }

    /**
     * Check if a schedule gets executed on a specific day
     *
     * @param string $day
     * @return bool
     */
    public function hasDay($day)
    {
        return in_array($day, $this->days);
    }

    /**
     * Check if a schedule gets executed on one or many specified days.
     * Optionally make the check strict.
     *
     * @param array $days
     * @param bool $strict
     * @return bool
     */
    public function hasDays(array $days, $strict = false)
    {
        return $strict
            ? empty(array_diff($days, $this->days))
            : !empty(array_intersect($this->days, $days));
    }

    /**
     * Get the string representation of the days on which
     * this schedule occurs
     *
     * @return string
     */
    public function getFormattedDays()
    {
        // Capitalize the first letter of every day
        $days = array_map('ucfirst', $this->days);

        return implode(', ', $days);
    }
}
