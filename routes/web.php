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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/home', 'HomeController@store');
Route::post('/personalSchedules', 'PersonalScheduleController@update'); //should be patch
Route::get('/chat', 'ChatController@index');
Route::post('/chat', 'ChatController@store');
Route::get('/chatHistory', 'ChatHistoryController@index');
Route::get('/profile', 'ProfileController@index');
Route::post('/profile', 'ProfileController@store');


// route for testing
Route::post('/test', function() {
	
	return 'hehehe';
	
});
