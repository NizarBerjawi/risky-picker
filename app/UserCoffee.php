<?php

namespace App;

use App\Coffee;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCoffee extends Pivot
{
    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'coffee_user';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['coffee'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sugar' => 'integer',
        'days' => 'collection',
    ];

    /**
     * Get the coffee this user's selection belongs to.
     *
     * @return BelongsTo
     */
    public function coffee() : BelongsTo
    {
      return $this->belongsTo(Coffee::class);
    }

    /**
     * Check if this coffee is of a certain coffee type.
     *
     * @param Coffee $coffee
     * @return bool
     */
    public function isOfType(Coffee $coffee) : bool
    {
        return $this->coffee->is($coffee);
    }

    /**
     * Check if this coffee is not of a certain coffee type.
     *
     * @param Coffee $coffee
     * @return bool
     */
     public function isNotOfType(Coffee $coffee) : bool
     {
         return !$this->isOfType($coffee);
     }

    /**
     * Get the string representation of the days on which
     * the user wants this coffee selection.
     *
     * @return string
     */
    public function getFormattedDays() : string
    {
        // Capitalize the first letter of every day
        $days = array_map('ucfirst', json_decode($this->days));

        return implode(', ', $days);
    }
}
