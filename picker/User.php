<?php

namespace Picker;

use Carbon\Carbon;
use Picker\{Cup, Coffee, CoffeeRun, Role, UserCoffee};
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\{Builder, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasOne, HasMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\{Notifiable, Notification};

class User extends Authenticatable
{
    use Notifiable, Sluggable, SoftDeletes;

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * Get all coffee runs the user has done.
     *
     * @return HasMany
     */
    public function coffeeRuns() : HasMany
    {
        return $this->hasMany(CoffeeRun::class);
    }

    /**
     * Get the coffees
     *
     * @param BelongsToMany
     */
    public function coffees() : BelongsToMany
    {
        return $this->belongsToMany(Coffee::class, 'user_coffee')
                    ->using(UserCoffee::class)
                    ->withTimestamps()
                    ->withPivot([
                        'id', 'sugar', 'start_time', 'end_time', 'days'
                    ]);
    }

    /**
     * Get all the coffees that this user has planned.
     *
     * @return HasMany
     */
    public function userCoffees() : HasMany
    {
        return $this->hasMany(UserCoffee::class);
    }

    /**
     * Get the user's planned coffees for today'
     *
     * @return HasMany
     */
    public function todaysCoffees() : HasMany
    {
        return $this->userCoffees()->today();
    }

    /**
     * Get the user's next planned coffee that will be delivered
     * in the next coffee run
     *
     * @return HasOne
     */
    public function nextCoffee()
    {
        return $this->hasOne(UserCoffee::class)->nextRun();
    }

    /**
     * Get all the user's adhoc coffees
     *
     * @return HasMany
     */
    public function adhocCoffees() : HasMany
    {
        return $this->hasMany(UserCoffee::class)->onlyAdhoc();
    }

    /**
     * The user's latest requested adhoc coffee
     *
     * @return HasOne
     */
    public function nextAdhocCoffee() : HasOne
    {
        $range = $this->nextCoffee()
                      ->select(['start_time', 'end_time'])
                      ->first()
                      ->toArray();

        return $this->hasOne(UserCoffee::class)
                    ->onlyAdhoc()
                    ->whereDate('created_at', today())
                    ->between(...array_values($range))
                    ->latest()
                    ->limit(1);
    }

    /**
     * Get the cup that belongs to this user.
     *
     * @return HasMany
     */
    public function cups() : HasMany
    {
        return $this->hasMany(Cup::class);
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

    /**
     * The roles that belong to the user.
     *
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if a user has a cup attached to their profile.
     *
     * @return bool
     */
    public function hasCup() : bool
    {
        return (bool) $this->cup;
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
     * Check if the user has a role. Returns true if
     * the role is applicable, and false otherwise.
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole(string $role) : bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if the user has a set of roles. Returns true if
     * they are all applicable, and false otherwise.
     *
     * @param array $roles
     * @return boolean
     */
     public function hasRoles(array $roles) : bool
     {
         $query = $this->roles();

         foreach($roles as $role) {
             $query->where('name', $role);
         }

         return $query->exists();
     }

     /**
      * Check if the user is an admin
      *
      * @return boolean
      */
     public function isAdmin() : bool
     {
         return $this->hasRoles(['admin']);
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
     * Get the full name of the user
     *
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return "$this->first_name $this->last_name";
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
                'source' => ['first_name', 'last_name'],
                'onUpdate' => true,
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
    public function routeNotificationForSlack(Notification $notification) : string
    {
        return config('logging.channels.slack.url');
    }
}
