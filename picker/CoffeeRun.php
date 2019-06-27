<?php

namespace Picker;

use Carbon\Carbon;
use Picker\{Type, User, UserCoffee};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class CoffeeRun extends Model
{
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
        'user_id', 'signed_url'
    ];

    /**
     * Get the user that made the coffee run.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
