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
    Route::get('/', 'UserController@index')->name('admin.users.index');
    Route::get('/invite', 'UserController@invitation')->name('admin.users.invitation');
    Route::post('/', 'UserController@invite')->name('admin.users.invite');

    Route::get('/{user}', 'UserController@show')->name('admin.users.show');
    Route::get('{user}/edit', 'UserController@edit')->name('admin.users.edit');
    Route::match(['put', 'patch'], '{user}', 'UserController@update')->name('admin.users.update');
    Route::get('{user}/delete', 'UserController@confirmDestroy')->name('admin.users.confirm-destroy');
    Route::delete('{user}', 'UserController@destroy')->name('admin.users.destroy');
});

Route::group(['prefix' => 'coffee'], function() {
    Route::get('/', 'CoffeeController@index')->name('admin.coffees.index');
    Route::get('/create', 'CoffeeController@create')->name('admin.coffees.create');
    Route::post('/', 'CoffeeController@store')->name('admin.coffees.store');
    Route::get('/{coffee}', 'CoffeeController@show')->name('admin.coffees.show');
    Route::get('/{coffee}/edit', 'CoffeeController@edit')->name('admin.coffees.edit');
    Route::match(['put', 'patch'], '/{coffee}', 'CoffeeController@update')->name('admin.coffees.update');
    Route::get('/{coffee}/delete', 'CoffeeController@confirmDestroy')->name('admin.coffees.confirm-destroy');
    Route::delete('/{coffee}', 'CoffeeController@destroy')->name('admin.coffees.destroy');
});

Route::group(['prefix' => 'schedules'], function() {
    Route::get('/', 'ScheduleController@index')->name('admin.schedules.index');
    Route::get('/create', 'ScheduleController@create')->name('admin.schedules.create');
    Route::post('/', 'ScheduleController@store')->name('admin.schedules.store');
    Route::get('/{schedule}', 'ScheduleController@show')->name('admin.schedules.show');
    Route::get('/{schedule}/edit', 'ScheduleController@edit')->name('admin.schedules.edit');
    Route::match(['put', 'patch'], '/{schedule}', 'ScheduleController@update')->name('admin.schedules.update');
    Route::get('/{schedule}/delete', 'ScheduleController@confirmDestroy')->name('admin.schedules.confirm-destroy');
    Route::delete('/{schedule}', 'ScheduleController@destroy')->name('admin.schedules.delete');
});
