<?php

namespace App\Models;

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
     * @param \App\Models\CoffeeRun
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRun(Builder $query, CoffeeRun $run)
    {
        return $this->whereHas('userCoffees', function(Builder $query) use ($run) {
            $query->byRun($run);
        })->distinct();
    }

    /**
     * Append the total number of each coffee type in
     * a specified coffee run
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param \App\Models\CoffeeRun
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCoffeeTotal(Builder $query, CoffeeRun $run = null)
    {
        $sub = UserCoffee::select('coffee_id')
            ->selectRaw('COUNT(coffee_id) as total')
            ->withTrashed()
            ->groupBy('coffee_id')
            ->when($run, function($query) use ($run) {
                $query->byRun($run);
            });

        return $query->withTrashed()
            ->joinSub($sub, 'coffee_counts', 'coffee_counts.coffee_id', '=', 'coffees.id');
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
