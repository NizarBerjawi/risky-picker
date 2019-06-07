<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Picker\UserCoffee::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, Picker\User::count()),
        'coffee_id' => $faker->numberBetween(1, Picker\Coffee::count()),
        'sugar' => $faker->numberBetween($min = 0, $max = 3),
        'start_time' => $faker->time($format = 'G:i', null),
        'end_time' => $faker->time($format = 'G:i', null),
        'days' => function () {
            // All the available days of the week
            $daysOfWeek = collect(Carbon::getDays());
            // Randomly pick a number of days
            $days = $daysOfWeek->random(mt_rand(1, count($daysOfWeek)));
            // Return the short english name of the week days
            return $days->map(function($day) { return strtolower(Carbon::parse($day)->shortEnglishDayOfWeek);})->all();
        }
    ];
});
