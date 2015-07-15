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


    //Branch
    Route::post('branch/index', 'BranchController@grid');
    Route::get('branch/index', 'BranchController@grid');

    Route::post('branch/create', 'BranchController@create');
    Route::get('branch/create', 'BranchController@create');

    Route::post('branch/edit', 'BranchController@edit');
    Route::get('branch/edit', 'BranchController@edit');
    //End Branch

    //Employee
    Route::post('employee/index', 'EmployeeController@grid');
    Route::get('employee/index', 'EmployeeController@grid');

    Route::post('employee/create', 'EmployeeController@create');
    Route::get('employee/create', 'EmployeeController@create');

    Route::post('employee/edit', 'EmployeeController@edit');
    Route::get('employee/edit', 'EmployeeController@edit');

    //End Employee


    //Dr
    Route::post('dr/index', 'DoctorController@grid');
    Route::get('dr/index', 'DoctorController@grid');

    Route::post('dr/create', 'DoctorController@create');
    Route::get('dr/create', 'DoctorController@create');

    Route::post('dr/edit', 'DoctorController@edit');
    Route::get('dr/edit', 'DoctorController@edit');
    //End Dr

    Route::post('vendor/manage', 'VendorController@create');
    Route::get('vendor/manage', 'VendorController@create');
    Route::post('product_type/manage', 'ProducttypeController@create');
    Route::get('product_type/manage', 'ProducttypeController@create');
});

Route::get('/login',    'UserController@getLogin');


Route::post('/auth',   'UserController@auth');

Route::controller('admin','AdminController');
Route::controller('user','UserController');
