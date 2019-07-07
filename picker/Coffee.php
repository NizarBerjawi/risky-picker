<?php

namespace Picker;

use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Cviebrock\EloquentSluggable\{Sluggable, SluggableScopeHelpers};

class Coffee extends Model
{
    use Sluggable, SluggableScopeHelpers, SoftDeletes;

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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Delete the user coffees that were associated
        // with this coffee type
        static::deleted(function($model) {
            $model->userCoffees()->delete();
        });
    }

    /**
     * The users that belong to this coffee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->using(UserCoffee::class);
    }

    /**
     * The coffee selections that belong to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCoffees()
    {
        return $this->hasMany(UserCoffee::class);
    }

    /**
     * Get the coffee types that are available in a specified run
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param CoffeeRun
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRun(Builder $query, CoffeeRun $run)
    {
        return $this->whereHas('userCoffees', function($query) use ($run) {
            $query->whereHas('runs', function($query) use ($run) {
                $query->where('id', $run->id);
            });
        })->distinct();
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
