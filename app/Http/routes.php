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



Route::group(['middleware' => 'permission:ADMIN'], function () {
    Route::post('user/manage', 'UserController@manage');
    Route::get('user/manage', 'UserController@manage');
    Route::post('course/manage', 'CourseController@create');
    Route::get('course/manage', 'CourseController@create');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@dashboard');
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/', 'HomeController@dashboard');
    Route::get('customer/newcus', 'CustomerController@create');
    Route::post('branch/manage', 'BranchController@create');
    Route::get('branch/manage', 'BranchController@create');
    Route::post('dr/manage', 'DoctorController@create');
    Route::get('dr/manage', 'DoctorController@create');
    Route::post('vendor/manage', 'VendorController@create');
    Route::get('vendor/manage', 'VendorController@create');
    Route::post('product_type/manage', 'ProducttypeController@create');
    Route::get('product_type/manage', 'ProducttypeController@create');
});

Route::get('/login',    'UserController@getLogin');
Route::controller('product','ProductController');

Route::post('/auth',   'UserController@auth');

Route::controller('admin','AdminController');
Route::controller('user','UserController');
