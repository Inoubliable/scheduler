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

Route::get('/home', 'HomeController@index')->middleware('auth');
Route::post('/home', 'HomeController@store')->middleware('auth');
Route::post('/personalSchedules', 'PersonalScheduleController@update')->middleware('auth'); // should be patch
Route::post('/removeSchedule', 'ScheduleController@store')->middleware('auth'); // should be delete
Route::post('/scheduleUser', 'ScheduleUserController@store')->middleware('auth');
Route::get('/chat', 'ChatController@index')->middleware('auth');
Route::post('/chat', 'ChatController@store')->middleware('auth');
Route::get('/chatHistory', 'ChatHistoryController@index')->middleware('auth');
Route::get('/profileImage', 'ProfileImageController@index')->middleware('auth');
Route::post('/profileImage', 'ProfileImageController@store')->middleware('auth');
Route::get('/myProfile', 'MyProfileController@index')->middleware('auth');
Route::get('/settings', 'SettingsController@index')->middleware('auth');
Route::get('/profile/{id}', 'ProfilesController@index')->middleware('auth');
Route::post('/addFriend', 'ProfilesController@store')->middleware('auth');
Route::get('/chatFocus', 'ChatFocusController@index')->middleware('auth');
Route::get('/search', 'SearchController@index')->middleware('auth');
Route::post('/changeEmail', 'ChangeEmailController@store')->middleware('auth');
Route::post('/changePassword', 'ChangePasswordController@store')->middleware('auth');
