<?php

namespace Picker;

use DateTime;
use Carbon\Carbon;
use Picker\Coffee;
use Picker\Support\Traits\ExcludesFromQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, Pivot};

class UserCoffee extends Pivot
{
    use ExcludesFromQuery;

    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'coffee_user';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['coffee'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sugar' => 'integer',
        'days' => 'array',
    ];

    /**
     * Get the coffee this user's selection belongs to.
     *
     * @return BelongsTo
     */
    public function coffee() : BelongsTo
    {
      return $this->belongsTo(Coffee::class);
    }

    /**
     * Get the user that this coffee belongs to
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all user coffees that are scheduled before a
     * certain time.
     *
     * @param Builder $query
     * @param string $time  "G:i"  or "h:i A" time format
     * @return Builder
     */
    public function scopeBefore(Builder $query, string $time) : Builder
    {
        $time = date("G:i", strtotime($time));

        return $query->whereRaw("time(start_time) <= time('$time')");
    }

    /**
     * Get all user coffees that are scheduled after a
     * certain time.
     *
     * @param Builder $query
     * @param string $time  "G:i"  or "h:i A" time format
     * @return Builder
     */
    public function scopeAfter(Builder $query, string $time) : Builder
    {
        $time = date("G:i", strtotime($time));

        return $query->whereRaw("time(end_time) >= time('$time')");
    }

    /**
     * Get all user coffees that fall within a certain time slot
     *
     * @param Builder $query
     * @param string $time  "G:i"  or "h:i A" time format
     * @return Builder
     */
    public function scopeBetween(Builder $query, string $start, string $end) : Builder
    {
      return $query->after($start)->before($end);
    }

    /**
     * Get all the user coffees that fall on specific days of the week
     *
     * @param Builder $query
     * @param array $days
     * @param bool $strict
     * @return Builder
     */
    public function scopeDays(Builder $query, array $days, bool $strict = false) : Builder
    {
        $operator = $strict ? 'and' : 'or';

        $query->where(function($query) use ($days, $operator) {
            foreach($days as $day) {
                $query->where('days', 'LIKE', "%$day%", $operator);
            }
        });

        return $query;
    }

    /**
     * Get all the user coffees that are on today's order
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeToday(Builder $query) : Builder
    {
        $today = Carbon::today()->dayOfWeek;

        dd($today);
        return $query->between(
            Carbon::now()->startOfDay()->format('G:i'),
            Carbon::now()->endOfDay()->format('G:i')
        );
    }

    /**
     * Check if this coffee is of a certain coffee type.
     *
     * @param Coffee $coffee
     * @return bool
     */
    public function isOfType(Coffee $coffee) : bool
    {
        return $this->coffee->is($coffee);
    }

    /**
     * Check if this coffee is not of a certain coffee type.
     *
     * @param Coffee $coffee
     * @return bool
     */
     public function isNotOfType(Coffee $coffee) : bool
     {
         return !$this->isOfType($coffee);
     }

     /**
      * Get the type of the user's coffee
      *
      * @return string
      */
     public function getTypeAttribute() : string
     {
         return $this->coffee->name;
     }

     /**
      * Set the start time of this coffee
      *
      * @return void
      */
     public function setStartTimeAttribute($value)
     {
         $this->attributes['start_time'] = date("G:i", strtotime($value));
     }

     /**
      * Set the end time of this coffee
      *
      * @return void
      */
     public function setEndTimeAttribute($value)
     {
         $this->attributes['end_time'] = date("G:i", strtotime($value));
     }

     /**
      * Get the start time of this coffee
      *
      * @return string
      */
     public function getStartTimeAttribute($value) : string
     {
         return date("h:i A", strtotime($value));
     }

     /**
      * Get the end time of this coffee
      *
      * @return string
      */
     public function getEndTimeAttribute($value) : string
     {
         return date("h:i A", strtotime($value));
     }

    /**
     * Get the string representation of the days on which
     * the user wants this coffee selection.
     *
     * @return string
     */
    public function getFormattedDays() : string
    {
        // Capitalize the first letter of every day
        $days = array_map('ucfirst', $this->days);

        return implode(', ', $days);
    }

    /**
     * Get the string representation of the user's coffee.
     *
     * @return string
     */
    public function __toString() : string
    {
        return "{$this->getType()} between
            $this->start_time and $this->end_time
            every {$this->getFormattedDays()}";
    }
}
