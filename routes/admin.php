<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UserController@index')->name('users.index');
    Route::get('/invite', 'UserController@invitation')->name('users.invitation');
    Route::post('/', 'UserController@invite')->name('users.invite');

    Route::get('/{user}', 'UserController@show')->name('users.show');
    Route::get('{user}/edit', 'UserController@edit')->name('users.edit');
    Route::match(['put', 'patch'], '{user}', 'UserController@update')->name('users.update');
    Route::get('{user}/delete', 'UserController@confirmDestroy')->name('users.confirm-destroy');
    Route::delete('{user}', 'UserController@destroy')->name('users.destroy');


    Route::group(['prefix' => '{user}/coffee'], function() {
        Route::get('/', 'UserCoffeeController@index')->name('users.coffees.index');
        Route::get('/create', 'UserCoffeeController@create')->name('users.coffees.create');
        Route::post('/', 'UserCoffeeController@store')->name('users.coffees.store');
        Route::get('/{userCoffee}', 'UserCoffeeController@show')->name('users.coffees.show');
        Route::get('/{userCoffee}/edit', 'UserCoffeeController@edit')->name('users.coffees.edit');
        Route::put('/{userCoffee}', 'UserCoffeeController@update')->name('users.coffees.update');
        Route::delete('/{userCoffee}', 'UserCoffeeController@destroy')->name('users.coffees.destroy');
    });
});

Route::group(['prefix' => 'coffee'], function() {
    Route::get('/', 'CoffeeController@index')->name('coffees.index');
    Route::get('/create', 'CoffeeController@create')->name('coffees.create');
    Route::post('/', 'CoffeeController@store')->name('coffees.store');
    Route::get('/{coffee}', 'CoffeeController@show')->name('coffees.show');
    Route::get('/{coffee}/edit', 'CoffeeController@edit')->name('coffees.edit');
    Route::put('/{coffee}', 'CoffeeController@update')->name('coffees.update');
    Route::get('/{coffee}/delete', 'CoffeeController@confirmDestroy')->name('coffees.confirm-destroy');
    Route::delete('/{coffee}', 'CoffeeController@destroy')->name('coffees.destroy');
});

Route::group(['prefix' => 'schedules'], function() {
    Route::get('/', 'ScheduleController@index')->name('schedules.index');
    Route::get('/create', 'ScheduleController@create')->name('schedules.create');
    Route::post('/', 'ScheduleController@store')->name('schedules.store');
    Route::get('/{schedule}', 'ScheduleController@show')->name('schedules.show');
    Route::get('/{schedule}/edit', 'ScheduleController@edit')->name('schedules.edit');
    Route::match(['put', 'patch'], '/{schedule}', 'ScheduleController@update')->name('schedules.update');
    Route::get('/{schedule}/delete', 'ScheduleController@confirmDestroy')->name('schedules.confirm-destroy');
    Route::delete('/{schedule}', 'ScheduleController@destroy')->name('schedules.delete');
});
