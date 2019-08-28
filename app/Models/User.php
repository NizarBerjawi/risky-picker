<?php

namespace App\Models;

use App\Support\Traits\ExcludesFromQuery;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\{Builder, SoftDeletes};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\{Notifiable, Notification};

class User extends Authenticatable
{
    use ExcludesFromQuery, Notifiable, Sluggable, SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['roles'];

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
        'first_name', 'last_name', 'is_vip', 'email', 'password',
    ];

    /**
     * Get all coffee runs the user has done.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coffeeRuns()
    {
        return $this->hasMany(CoffeeRun::class);
    }

    /**
     * Get the coffees
     *
     * @param \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coffees()
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCoffees()
    {
        return $this->hasMany(UserCoffee::class);
    }

    /**
     * Get the user's planned coffees for today'
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todaysCoffees()
    {
        return $this->userCoffees()->today();
    }

    /**
     * Get the user's next planned coffee that will be delivered
     * in the next coffee run
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nextCoffee()
    {
        return $this->hasOne(UserCoffee::class)->nextRun();
    }

    /**
     * Get all the user's adhoc coffees
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adhocCoffees()
    {
        return $this->hasMany(AdhocUserCoffee::class);
    }

    /**
     * The user's latest requested adhoc coffee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nextAdhocCoffee()
    {
        $next = $this->nextCoffee()
                     ->select(['start_time', 'end_time'])
                     ->first();

        if (empty($next)) { return $this->nextCoffee(); }

        return $this->hasOne(AdhocUserCoffee::class)
                    ->whereDate('created_at', today())
                    ->between(...array_values($next->toArray()))
                    ->latest()
                    ->limit(1);
    }

    /**
     * Get the cup that belongs to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cup()
    {
        return $this->hasOne(Cup::class);
    }

    /**
     * The roles that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the users that are in the pool of users to be picked
     *
     * @return \Illuminate\Database\Eloquent\Builder;
     */
    public function scopeWithoutVip(Builder $query)
    {
        return $query->where('is_vip', false);
    }

    /**
     * Get the users that are not in the pool of users to be picked
     *
     * @return \Illuminate\Database\Eloquent\Builder;
     */
    public function scopeOnlyVip(Builder $query)
    {
        return $query->where('is_vip', true);
    }

    /**
     * Check if a user has a cup attached to their profile.
     *
     * @return bool
     */
    public function hasCup()
    {
        return (bool) $this->cup;
    }

    /**
     * Check if a user does not have a cup attached to
     * their profile.
     *
     * @return bool
     */
    public function doesntHaveCup()
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
    public function hasRole(string $role)
    {
        return $this->roles->contains('name', $role);

    }

    /**
     * Check if the user has a set of roles. Returns true if
     * they are all applicable, and false otherwise.
     *
     * @param array $roles
     * @return boolean
     */
     public function hasRoles(array $roles)
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
     public function isAdmin()
     {
         return $this->hasRole('admin');
     }

     /**
      * Check if a user is to be added to the pool of pickable users
      *
      * @return bool
      */
     public function isVIP()
     {
         return (boolean) $this->is_vip;
     }

     /**
      * Check if a user has volunteered for a specified coffee run
      *
      * @return bool
      */
     public function hasVolunteeredFor(CoffeeRun $run)
     {
         return $run->volunteer_id == $this->id;
     }

     /**
      * Check if a user has been picked for a specified coffee run
      *
      * @return bool
      */
     public function hasBeenPickedFor(CoffeeRun $run)
     {
         return $run->user_id == $this->id;
     }

    /**
     * Determine if a user can be picked to do a coffee run.
     *
     * @return bool
     */
    public function canBePickedForCoffee()
    {
        return !$this->pickedLastTime() &&
               !$this->pickedToday() &&
               !$this->pickedYesterday();
    }

    /**
     * Detrmine if the user was picked last time to do a
     * coffee run. i.e this could be after a public holiday
     * or a weekend
     *
     * @return bool
     */
    public function pickedLastTime()
    {
        // Get the last coffee run and the user who made it
        $run = CoffeeRun::lastRun()
                        ->with('user')
                        ->first();

        return $run && $this->is($run->user);
    }

    /**
     * Determine if the user did a coffee run today
     *
     * @return bool
     */
    public function pickedToday()
    {
        return $this->coffeeRuns()
                    ->today()
                    ->exists();
    }

    /**
     * Determine if the user did a coffee run yesterday
     *
     * @return bool
     */
    public function pickedYesterday()
    {
        return $this->coffeeRuns()
                    ->yesterday()
                    ->exists();
    }

    /**
     * Get the full name of the user
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
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
    public function getRouteKeyName()
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
        return config('logging.channels.slack.url');
    }
}
