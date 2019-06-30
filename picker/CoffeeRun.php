<?php

namespace Picker;

use Carbon\Carbon;
use Picker\{Type, User, UserCoffee};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class CoffeeRun extends Model
{
    /**
     * The number of minutes before a particular coffee run expires
     *
     * @var int
     */
    const EXPIRY = 4500; // Minutes;

    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'coffee_runs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_busy', 'volunteer_id', 'signed_url'
    ];

    /**
     * Get the user that was selected to do the coffee run.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that made the coffee run.
     *
     * @return BelongsTo
     */
    public function volunteer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    /**
     * Get all the user coffees that were part of this
     * coffee run
     *
     * @return HasMany
     */
    public function coffees()
    {
        return $this->belongsToMany(UserCoffee::class, 'coffee_run_user_coffee', 'coffee_run_id', 'user_coffee_id')
                    ->withAdhoc();
    }

    /**
     * Scope the orders that were made today
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeToday(Builder $query) : Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Scope the orders that were made yesterday
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeYesterday(Builder $query) : Builder
    {
        return $query->whereDate('created_at', Carbon::yesterday());
    }

    /**
     * Scope the last order that was made
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeLastRun(Builder $query) : Builder
    {
        return $query->latest()->limit(1);
    }

    /**
     * Scope the orders by the user who made them
     *
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeByUser(Builder $query, User $user) : Builder
    {
        return $query->whereHas('user', function($query) use ($user) {
            $query->where('id', $user->id);
        });
    }

    /**
     * Set the user who was chosen to do the run as busy
     *
     * @return boolean
     */
    public function setBusyUser() : bool
    {
        return $this->fill([
            'user_busy' => true
        ])->save();
    }

    /**
     * Set the user who volunteered to do the run
     *
     * @param User $user
     * @return boolean
     */
    public function addVolunteer(User $user) : bool
    {
        return $this->fill([
            'volunteer_id' => $user->id,
        ])->save();
    }

    /**
     * Check if the user selected to do this run is busy.
     *
     * @return bool
     */
    public function volunteerRequested() : bool
    {
        return (bool) $this->user_busy;
    }

    /**
     * Check if the coffee run needs a volunteer.
     *
     * @return bool
     */
    public function needsVolunteer() : bool
    {
        return $this->volunteerRequested() && !$this->hasVolunteer();
    }

    /**
     * Check if the coffee run needs a volunteer.
     *
     * @return bool
     */
    public function hasVolunteer() : bool
    {
        return !is_null($this->volunteer_id);
    }

    /**
     * Check if the coffee run has expired
     *
     * @return bool
     */
    public function expired() : bool
    {
        return now()->diffInMinutes($this->created_at) > self::EXPIRY;
    }

    /**
     * Check if the coffee run has not expired yet
     *
     * @return bool
     */
    public function notExpired() : bool
    {
        return !$this->expired();
    }
}
