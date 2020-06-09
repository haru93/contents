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

Route::get('/' , 'ReviewController@index')->name('review.index');

Route::group(['prefix' => 'review', 'middleware' => 'auth'], function () {
    Route::get('create', 'ReviewController@create')->name('review.create');
    Route::post('store', 'ReviewController@store')->name('review.store');
    Route::get('show/{id}', 'ReviewController@show')->name('review.show');
    Route::get('edit/{id}', 'ReviewController@edit')->name('review.edit');
    Route::post('update/{id}', 'ReviewController@update')->name('review.update');
});

Route::get('/home', 'HomeController@index')->name('home');
