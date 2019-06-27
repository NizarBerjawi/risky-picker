<?php

namespace Picker;

use Carbon\Carbon;
use Picker\UserCoffee\Scopes\AdhocScope;
use Picker\Support\Traits\ExcludesFromQuery;
use Illuminate\Database\Eloquent\{Builder, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, Pivot};
use Illuminate\Support\Facades\URL;

class UserCoffee extends Pivot
{
    use ExcludesFromQuery, SoftDeletes;

    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'user_coffee';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sugar' => 'integer',
        'days' => 'array',
        'is_adhoc' => 'boolean',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdhocScope);
    }

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
     * Get the coffee runs that this user coffee is part off.
     *
     * @return BelongsToMany
     */
    public function runs() : BelongsToMany
    {
        return $this->belongsToMany(CoffeeRun::class, 'coffee_run_user_coffee', 'user_coffee_id', 'coffee_run_id');
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
        $boolean = $strict ? 'and' : 'or';

        $query->where(function($query) use ($days, $boolean) {
            foreach($days as $day) {
                $query->where('days', 'LIKE', "%$day%", $boolean);
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
        $today = Carbon::today();

        return $query->between(
            $today->startOfDay()->format('G:i'),
            $today->endOfDay()->format('G:i')
        )->days([strtolower($today->shortEnglishDayOfWeek)]);
    }

    /**
     * Get all the user coffees that could be part of the next
     * coffee run.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNextRun(Builder $query) : Builder
    {
        $now = Carbon::now();

        // The user is not allowed to create coffee that overlap
        // in time range. We can safely assume that there will only be
        // a maximum of 1 coffee per user at any given time/day
        // combination
        return $query->between($now->format('G:i'), $now->format('G:i'))
                     ->days([strtolower($now->shortEnglishDayOfWeek)]);
    }

    /**
     * Get a signed url that allows the user to replace this
     * coffee with another adhoc coffee for a particular coffee run.
     *
     * @return string
     */
    public function getAdhocUrlAttribute() : string
    {
        $expires = now()->addHours(1);

        return URL::temporarySignedRoute('dashboard.coffee.create', $expires, [
            'id' => $this->id,
            'is_adhoc' => true,
            'run_id' => $this->runs()->lastRun()->first()->id,
        ]);
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
     * A function to validate that a user coffee's start and end
     * times are valid.
     *
     * @param string
     * @param string
     * @return bool
     */
    public static function validateTimeRange($start, $end) : bool
    {
        $startTime = Carbon::parse(date("G:i", strtotime($start)));
        $endTime = Carbon::parse(date("G:i", strtotime($end)));

        return $startTime->lt($endTime);
    }

    /**
     * Check if a new coffee not yet stored in the database could
     * cause a conflict with one of the user's other previously
     * created coffees.
     *
     * @param User $user
     * @param UserCoffee $new
     * @param UserCoffee|null $existing
     */
    public static function timeslotConflict(User $user, UserCoffee $coffee) : bool
    {
        return $user->userCoffees()
                    ->between($coffee->start_time, $coffee->end_time)
                    ->days($coffee->days)
                    ->when($coffee->exists, function($query) use ($coffee) {
                        $query->exclude([$coffee]);
                    })
                    ->exists();
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
