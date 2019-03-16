<?php

namespace App;

use Carbon\Carbon;
use App\{User, Type};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'user_id',
    ];

    /**
     * Get the user that made the order.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the type of the order.
     *
     * @return BelongsTo
     */
    public function type() : BelongsTo
    {
        return $this->belongsTo(Type::class);
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
    public function scopeLastOrder(Builder $query) : Builder
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
     * Scope coffee orders that were made
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCoffee(Builder $query) : Builder
    {
        return $query->whereHas('type', function($query) {
            $query->where('name', 'coffee');
        });
    }

    /**
     * Scope food orders that were made
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFood(Builder $query) : Builder
    {
        return $query->whereHas('type', function($query) {
            $query->where('name', 'food');
        });
    }
}
