<?php

namespace Picker\Coffee;

use Picker\User\User;
use Picker\UserCoffee\UserCoffee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany};
use Cviebrock\EloquentSluggable\{Sluggable, SluggableScopeHelpers};

class Coffee extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'coffees';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * The users that belong to this coffee
     *
     * @return BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->using(UserCoffee::class);
    }

    /**
     * The coffee selections that belong to the user
     *
     * @return HasMany
     */
    public function userCoffees() : HasMany
    {
        return $this->hasMany(UserCoffee::class);
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
                'source' => 'name',
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
}
