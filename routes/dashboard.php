<?php

Route::get('/', 'UserController@edit')->name('dashboard.profile.edit');

Route::group(['prefix' => 'profile'], function() {
    Route::get('/', 'UserController@edit')->name('dashboard.profile.edit');
    Route::match(['put', 'patch'], '/', 'UserController@update')->name('dashboard.profile.update');
});

Route::group(['prefix' => 'coffees'], function() {
    Route::get('/', 'CoffeeController@index')->name('dashboard.coffee.index');
    Route::get('/create', 'CoffeeController@create')->name('dashboard.coffee.create');
    Route::post('/', 'CoffeeController@store')->name('dashboard.coffee.store');
    Route::get('/{userCoffee}/edit', 'CoffeeController@edit')->name('dashboard.coffee.edit');
    Route::match(['put', 'patch'], '/{userCoffee}', 'CoffeeController@update')->name('dashboard.coffee.update');
    Route::delete('/{userCoffee}', 'CoffeeController@destroy')->name('dashboard.coffee.delete');
});

Route::group(['prefix' => 'cups'], function() {
    Route::get('/', 'CupController@index')->name('dashboard.cups.index');
    Route::get('/create', 'CupController@create')->name('dashboard.cups.create');
    Route::post('/', 'CupController@store')->name('dashboard.cups.store');
    Route::get('{cup}/edit', 'CupController@edit')->name('dashboard.cups.edit');
    Route::match(['put', 'patch'], '/{cup}', 'CupController@update')->name('dashboard.cups.update');
    Route::delete('/{cup}', 'CupController@destroy')->name('dashboard.cups.delete');
});

Route::group(['prefix' => 'coffee-run'], function() {
    Route::get('/', 'CoffeeRunController@index')->name('dashboard.runs.index');
    Route::get('/{run}', 'CoffeeRunController@show')->name('dashboard.runs.show');
    Route::post('/{run}/busy', 'CoffeeRunController@busy')->name('dashboard.runs.busy');
    Route::post('/{run}/volunteer', 'CoffeeRunController@volunteer')->name('dashboard.runs.volunteer');
    Route::match(['put', 'patch'], '/{run}', 'CoffeeRunController@update')->name('dashboard.runs.update');
    Route::get('/{run}/coffee/{coffee}', 'CoffeeRunController@preRemove')->name('dashboard.runs.confirm-remove');
    Route::match(['put', 'patch'], '/{run}/coffee/{coffee}', 'CoffeeRunController@remove')->name('dashboard.runs.remove');
});
