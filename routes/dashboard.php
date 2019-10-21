<?php

Route::group(['prefix' => 'profile'], function() {
    Route::get('/', 'UserController@show')->name('dashboard.profile.show');
    Route::get('/edit', 'UserController@edit')->name('dashboard.profile.edit');
    Route::match(['put', 'patch'], '/', 'UserController@update')->name('dashboard.profile.update');
});

Route::group(['prefix' => 'coffees'], function() {
    Route::get('/', 'CoffeeController@index')->name('dashboard.coffee.index');
    Route::get('/create', 'CoffeeController@create')->name('dashboard.coffee.create');
    Route::post('/', 'CoffeeController@store')->name('dashboard.coffee.store');
    Route::get('/{userCoffee}/edit', 'CoffeeController@edit')->name('dashboard.coffee.edit');
    Route::get('/{userCoffee}', 'CoffeeController@show')->name('dashboard.coffee.show');
    Route::match(['put', 'patch'], '/{userCoffee}', 'CoffeeController@update')->name('dashboard.coffee.update');
    Route::get('/{userCoffee}/delete', 'CoffeeController@confirmDestroy')->name('dashboard.coffee.confirm-delete');
    Route::delete('/{userCoffee}', 'CoffeeController@destroy')->name('dashboard.coffee.delete');
});

Route::group(['prefix' => 'adhoc-coffees'], function() {
    Route::get('{run}/create', 'AdhocCoffeeController@create')->name('dashboard.adhoc.create');
    Route::post('/{run}', 'AdhocCoffeeController@store')->name('dashboard.adhoc.store');
});

Route::group(['prefix' => 'cups'], function() {
    Route::get('/', 'CupController@index')->name('dashboard.cups.index');
    Route::get('/create', 'CupController@create')->name('dashboard.cups.create');
    Route::post('/', 'CupController@store')->name('dashboard.cups.store');
    Route::get('{cup}/edit', 'CupController@edit')->name('dashboard.cups.edit');
    Route::get('{cup}', 'CupController@show')->name('dashboard.cups.show');
    Route::match(['put', 'patch'], '/{cup}', 'CupController@update')->name('dashboard.cups.update');
    Route::get('/{cup}/delete', 'CupController@confirmDestroy')->name('dashboard.cups.confirm-delete');
    Route::delete('/{cup}', 'CupController@destroy')->name('dashboard.cups.delete');
});

Route::group(['prefix' => 'coffee-run'], function() {
    Route::get('/', 'CoffeeRunController@index')->name('dashboard.runs.index');
    Route::get('/statistics', 'CoffeeRunController@statistics')->name('dashboard.runs.statistics');
    Route::get('/{run}', 'CoffeeRunController@show')->name('dashboard.runs.show');
    Route::post('/{run}/busy', 'CoffeeRunController@busy')->name('dashboard.runs.busy');
    Route::post('/{run}/volunteer', 'CoffeeRunController@volunteer')->name('dashboard.runs.volunteer');
    Route::match(['put', 'patch'], '/{run}', 'CoffeeRunController@update')->name('dashboard.runs.update');
    Route::get('/{run}/coffee/{coffee}/delete', 'CoffeeRunController@preRemove')->name('dashboard.runs.confirm-remove');
    Route::match(['put', 'patch'], '/{run}/coffee/{coffee}', 'CoffeeRunController@remove')->name('dashboard.runs.remove');
});
