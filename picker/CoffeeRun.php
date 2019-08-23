<?php

namespace Picker;

use Carbon\Carbon;
use Picker\{Coffee, User, UserCoffee, Schedule};
use Picker\Support\Filters\Filterable;
use Picker\Support\Uuid\HasUuid;
use Illuminate\Database\Eloquent\{Builder, Model};

class CoffeeRun extends Model
{
    use Filterable, HasUuid;

    /**
     * The number of minutes before a particular coffee run expires
     *
     * @var int
     */
    const EXPIRY = 6000; // Minutes;

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
     * Get the user that made the coffee run.
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
     * Scope the orders that were made today
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday(Builder $query)
    {
        return $query->whereDate('created_at', Carbon::today())->latest();
    }

    /**
     * Scope the orders that were made yesterday
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYesterday(Builder $query)
    {
        return $query->whereDate('created_at', Carbon::yesterday())->latest();
    }

    /**
     * Scope the last order that was made
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastRun(Builder $query)
    {
        return $query->latest()->limit(1);
    }

    /**
     * Scope the orders by the user who made them
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser(Builder $query, User $user)
    {
        return $query->whereHas('user', function(Builder $query) use ($user) {
            $query->where('id', $user->id);
        });
    }

    /**
     * Get the coffee of a specific user from this ru
     *
     * @param User $user
     * @return UserCoffee
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
     * @param User $user
     * @return boolean
     */
    public function addVolunteer(User $user)
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
    public function changeUser(User $user)
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
}
