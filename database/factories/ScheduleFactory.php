<?php

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

$factory->define(Picker\Schedule::class, function (Faker $faker) {
    return [
        'time' => $faker->unique()->time($format = 'G:i', null),
        'days' => function () {
            // All the available days of the week
            $daysOfWeek = collect(days())->keys();
            // Randomly pick a number of days
            $days = $daysOfWeek->random(mt_rand(1, count($daysOfWeek)));
            // Return the short english name of the week days
            return $days->all();
        }
    ];
});
