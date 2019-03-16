<?php

namespace App;

use Carbon\Carbon;
use App\{Order, Coffee, UserCoffee, Cup};
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
{
    use Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['cup'];

    /**
     * Get all orders the user has done.
     *
     * @return HasMany
     */
    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the coffees
     *
     * @param BelongsToMany
     */
    public function coffees() : BelongsToMany
    {
        return $this->belongsToMany(Coffee::class)
                    ->using(UserCoffee::class)
                    ->withPivot([
                        'id', 'sugar', 'start_time', 'end_time', 'days'
                    ]);
    }

    /**
     * Get all the coffees that this user wants.
     *
     * @return HasMany
     */
    public function userCoffees() : HasMany
    {
        return $this->hasMany(UserCoffee::class);
    }

    /**
     * Get the cup that belongs to this user.
     *
     * @return HasOne
     */
    public function cup() : HasOne
    {
        return $this->hasOne(Cup::class);
    }

    public function scopePickable(Builder $query)
    {

    }

    /**
     * Check if a user has a cup attached to their profile.
     *
     * @return bool
     */
    public function hasCup() : bool
    {
        return $this->cup()->exists();
    }

    /**
     * Check if a user does not have a cup attached to
     * their profile.
     *
     * @return bool
     */
    public function doesnttHaveCup() : bool
    {
        return !$this->hasCup();
    }

    /**
     * Check if a user can be picked to make
     * an order of a certain type
     *
     * @return bool
     */
    public function canBePickedFor(Type $type) : bool
    {
        return $type->name === 'food'
            ? $this->canBePickedForFood()
            : $this->canBePickedForCoffee();
    }

    /**
     * Check if a user can be picked to make
     * an order of a certain type
     *
     * @return bool
     */
    public function canNotBePickedFor(Type $type) : bool
    {
        return !$this->canBePickedFor($type);
    }

    /**
     * Determine if a user can be picked for coffee run.
     *
     * @return bool
     */
    public function canBePickedForCoffee() : bool
    {
        return !$this->pickedLastTime() &&
               !$this->pickedToday() &&
               !$this->pickedYesterday();
    }

    /**
     * Determine if a user can be picked for food order.
     *
     * @return bool
     */
    public function canBePickedForFood() : bool
    {
        return !$this->pickedToday() &&
               !$this->pickedForFoodLastTime();
    }

    /**
     * Detrmine if the user was picked last time regardless
     * of order type.
     *
     * @return bool
     */
    public function pickedLastTime() : bool
    {
        // Get the last order made by any user
        $order = Order::lastOrder()
                      ->with('user')
                      ->first();

        return $order && $this->is($order->user);
    }

    /**
     * Detrmine if the user was picked last time for food
     * order
     *
     * @return bool
     */
    public function pickedForFoodLastTime() : bool
    {
        // Get the last food order made by any user
        $order = Order::food()
                      ->lastOrder()
                      ->with('user')
                      ->first();

        return $order && $this->is($order->user);
    }

    /**
     * Determine the user was picked today regardless
     * of order type.
     *
     * @return bool
     */
    public function pickedToday() : bool
    {
        return $this->orders()
                    ->today()
                    ->exists();
    }

    /**
     * Determine the user was picked yesterday regardless
     * of order type.
     *
     * @return bool
     */
    public function pickedYesterday() : bool
    {
        return $this->orders()
                    ->yesterday()
                    ->exists();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack(Notification $notification)
    {
        return 'https://hooks.slack.com/services/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';
    }
}
