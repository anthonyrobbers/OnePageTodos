<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('about','ListController@about');
Route::get('/','ListController@index');
Route::post('/','ListController@store');
Route::resource('laraveltodos','ListController');