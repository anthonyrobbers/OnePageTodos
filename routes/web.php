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




Route::get('mvc','TodoItemController@viewMvc');
Route::get('about','TodoItemController@about');
Route::get('/','TodoItemController@index');
Route::post('/','TodoItemController@store');

Route::patch('TodoItem/{id}/undo','TodoItemController@undo');
Route::get('TodoItem/{id}/complete','TodoItemController@toggleComplete');
Route::get('complete','TodoItemController@markAllComplete');

Route::resource('TodoItem','TodoItemController');

Route::resource('optionList','optionListController');



