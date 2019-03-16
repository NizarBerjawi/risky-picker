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
    Route::get('/create', 'UserController@create')->name('users.create');
    Route::post('/', 'UserController@store')->name('users.store');
    Route::get('/{user}', 'UserController@show')->name('users.show');
    Route::get('{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('{user}', 'UserController@update')->name('users.update');
    Route::delete('{user}', 'UserController@destroy')->name('users.destroy');

    Route::group(['prefix' => '{user}/coffee'], function() {
        Route::get('/', 'CoffeeController@index')->name('coffees.index');
        Route::get('/create', 'CoffeeController@create')->name('coffees.create');
        Route::post('/', 'CoffeeController@store')->name('coffees.store');
        Route::get('/{userCoffee}', 'CoffeeController@show')->name('coffees.show');
        Route::get('/{userCoffee}/edit', 'CoffeeController@edit')->name('coffees.edit');
        Route::put('/{userCoffee}', 'CoffeeController@update')->name('coffees.update');
        Route::delete('/{userCoffee}', 'CoffeeController@destroy')->name('coffees.destroy');
    });
});


Route::group(['prefix' => 'restaurants'], function() {
    Route::get('/', 'RestaurantController@index')->name('restaurants.index');
    Route::get('/create', 'RestaurantController@create')->name('restaurants.create');
    Route::post('/', 'RestaurantController@store')->name('restaurants.store');
    Route::get('{restaurant}/edit', 'RestaurantController@edit')->name('restaurants.edit');
    Route::put('{restaurant}', 'RestaurantController@update')->name('restaurants.update');
});

Route::get('/', 'PickerController@index')->name('picker');
Route::post('/', 'PickerController@pick')->name('pick');
Route::get('/{type}/{user}', 'PickerController@show')->name('pick.user');
Route::post('/{type}/{user}', 'PickerController@confirm')->name('pick.confirm');
