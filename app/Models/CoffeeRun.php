<?php

namespace App\Models;

use Carbon\Carbon;
use App\Support\Filters\Filterable;
use App\Support\Uuid\HasUuid;
use Illuminate\Database\Eloquent\{Builder, Model};

class CoffeeRun extends Model
{
    use Filterable, HasUuid;

    /**
     * The number of minutes before a particular coffee run expires
     *
     * @var int
     */
    const EXPIRY = 1440; // Minutes;

    /**
     * The number of minutes before a particular coffee run
     * becomes locked
     *
     * @var int
     */
    const LOCK_AFTER = 60; // Minutes;

    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'coffee_runs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $uuid = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_busy', 'volunteer_id'
    ];

    /**
     * Get the user that was selected to do the coffee run.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that volunteered to do the coffee run
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    /**
     * Get all the user coffees that were part of this
     * coffee run
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userCoffees()
    {
        return $this->belongsToMany(UserCoffee::class, 'coffee_run_user_coffee', 'coffee_run_id', 'user_coffee_id');
    }

    /**
     * Get the coffee runs that were made today
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday(Builder $query)
    {
        return $query->whereDate('created_at', Carbon::today())->latest();
    }

    /**
     * Get the coffee runs that were made yesterday
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYesterday(Builder $query)
    {
        return $query->whereDate('created_at', Carbon::yesterday())->latest();
    }

    /**
     * Get the last coffee run that was made
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastRun(Builder $query)
    {
        return $query->where('created_at', static::query()->max('created_at'))
                     ->limit(1);
    }

    /**
     * Get the coffee runs that have happened recently. Recent
     * coffee runs are defined as runs that have happened today,
     * yesterday, or on the last run
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent(Builder $query)
    {
        return $query->where(function(Builder $query) {
            $query->today();
        })->orWhere(function(Builder $query) {
            $query->yesterday();
        })->orWhere(function(Builder $query) {
            $query->lastRun();
        });
    }

    /**
     * Get the coffee runs that were made this week
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisWeek(Builder $query)
    {
        $time = Carbon::now()->subWeeks(1);

        return $query->whereDate('created_at', '>', $time);
    }

    /**
     * Get the coffee runs that were made this month
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisMonth(Builder $query)
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        return $query->whereDate('coffee_runs.created_at', '>=', $start)
                     ->whereDate('coffee_runs.created_at', '<=', $end);
    }

    /**
     * Scope the coffee runs by the user who made them
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param \App\Models\User
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser(Builder $query, User $user)
    {
        return $query->whereHas('user', function(Builder $query) use ($user) {
            $query->where('id', $user->id);
        });
    }

    /**
     * Scope the coffee runs that have a volunteer
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasVolunteer(Builder $query)
    {
        return $query->whereNotNull('volunteer_id');
    }

    /**
     * Get the coffee of a specific user from this ru
     *
     * @param  \App\Models\User
     * @return \App\Models\UserCoffee
     */
    public function getUserCoffee(User $user)
    {
        return $this->userCoffees()
                    ->where('user_id', $user->id)
                    ->first();
    }

    /**
     * Set the user who was chosen to do the run as busy
     *
     * @return boolean
     */
    public function setBusyUser()
    {
        return $this->fill([
            'user_busy' => true
        ])->save();
    }

    /**
     * Set the user who volunteered to do the run
     *
     * @param \App\Models\User $user
     * @return boolean
     */
    public function addVolunteer(User $user)
    {
        if($user->hasBeenPickedFor($this)) {
            return $this->setUser($user);
        }

        return $this->fill([
            'volunteer_id' => $user->id,
        ])->save();
    }

    /**
     * Check if the user selected to do this run is busy.
     *
     * @return bool
     */
    public function volunteerRequested()
    {
        return (bool) $this->user_busy;
    }

    /**
     * Check if the coffee run needs a volunteer.
     *
     * @return bool
     */
    public function needsVolunteer()
    {
        return $this->volunteerRequested() && !$this->hasVolunteer();
    }

    /**
     * Check if the coffee run needs a volunteer.
     *
     * @return bool
     */
    public function hasVolunteer()
    {
        return !is_null($this->volunteer_id);
    }

    /**
     * Change the user doing the run and reset any settings
     *
     * @return bool
     */
    public function setUser(User $user)
    {
        return $this->update([
            'user_id' => $user->id,
            'user_busy' => false,
            'volunteer_id' => null,
        ]);
    }

    /**
     * Check if the coffee run has expired
     *
     * @return bool
     */
    public function expired()
    {
        return now()->diffInMinutes($this->created_at) > self::EXPIRY;
    }

    /**
     * Check if the coffee run has not expired yet
     *
     * @return bool
     */
    public function notExpired()
    {
        return !$this->expired();
    }

    /**
     * Check if the coffee run is locked
     *
     * @return boolean
     */
    public function locked()
    {
        return now()->diffInMinutes($this->created_at) > self::LOCK_AFTER;
    }

    /**
     * Check if the coffee run is not locked
     *
     * @return boolean
     */
    public function notLocked()
    {
        return !$this->locked();
    }
}
