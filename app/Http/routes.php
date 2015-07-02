<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    Route::get('/test', 'HomeController@test');

Route::group(['middleware' => 'permission:ADMIN'], function () {
    Route::post('user/manage', 'UserController@manage');
    Route::get('user/manage', 'UserController@manage');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@dashboard');
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/', 'HomeController@dashboard');

});

Route::get('/login',    'UserController@getLogin');
Route::controller('product','ProductController');

Route::post('/auth',   'UserController@auth');

Route::controller('admin','AdminController');
Route::controller('user','UserController');
