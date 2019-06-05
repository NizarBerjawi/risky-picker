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

Auth::routes();

Route::group(['prefix' => 'coffee-run'], function() {
  Route::get('/', 'CoffeeRunController@index')->name('picker.run');
  Route::get('orders', 'PickerController@update')->name('');
  Route::post('/', 'PickerController@pick')->name('pick');
  // Route::get('/{user}', 'PickerController@show')->name('pick.user');
  // Route::post('/{user}', 'PickerController@confirm')->name('pick.confirm');
});

Route::get('/', 'Auth\LoginController@showLoginForm')->name('home');
