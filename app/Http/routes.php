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

    //Course
    Route::post('course/index', 'CourseController@grid');
    Route::get('course/index', 'CourseController@grid');
    Route::post('course/create', 'CourseController@create');
    Route::get('course/create', 'CourseController@create');
    Route::any('course/edit', 'CourseController@edit');

    //Product Type
    Route::post('product_type/index', 'Product_typeController@grid');
    Route::get('product_type/index', 'Product_typeController@grid');

    Route::post('product_type/create', 'Product_typeController@create');
    Route::get('product_type/create', 'Product_typeController@create');
    Route::any('product_type/edit', 'Product_typeController@edit');

    //Product group
    Route::post('product_group/index', 'Product_groupController@grid');
    Route::get('product_group/index', 'Product_groupController@grid');
    Route::post('product_group/create', 'Product_groupController@create');
    Route::get('product_group/create', 'Product_groupController@create');
    Route::any('product_group/edit', 'Product_groupController@edit');
    //End Product group

    //Dr
    Route::post('dr/index', 'DoctorController@grid');
    Route::get('dr/index', 'DoctorController@grid');
    Route::post('dr/create', 'DoctorController@create');
    Route::get('dr/create', 'DoctorController@create');
    Route::any('dr/edit', 'DoctorController@edit');
    Route::post('dr/calender', 'DoctorController@calender');
    Route::get('dr/calender', 'DoctorController@calender');
    //End Dr

    //Employee
    Route::post('employee/index', 'EmployeeController@grid');
    Route::get('employee/index', 'EmployeeController@grid');

    Route::post('employee/create', 'EmployeeController@create');
    Route::get('employee/create', 'EmployeeController@create');

    Route::any('employee/edit', 'EmployeeController@edit');
    //End Employee

});
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@dashboard');
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/', 'HomeController@dashboard');

    //Treatment
    Route::post('treatment/index','TreatmentController@grid');
    Route::get('treatment/index','TreatmentController@grid');

    Route::post('treatment/create','TreatmentController@create');
    Route::get('treatment/create','TreatmentController@create');
    //End Treatment

    //Quotations
    Route::post('quotations','QuotationsController@index');
    Route::get('quotations','QuotationsController@index');
    Route::get('quotations/query', 'QuotationsController@getCustomerList');
    Route::get('quotations/course_query', 'QuotationsController@getCourseList');
    Route::get('quotations/update', 'QuotationsController@update');
    Route::get('quotations/add', 'QuotationsController@add');
    Route::get('quotations/delete', 'QuotationsController@delete');
    Route::get('quotations/data', 'QuotationsController@getData');

    //Customer
    Route::post('customer/index', 'CustomerController@grid');
    Route::get('customer/index', 'CustomerController@grid');
    Route::post('customer/create', 'CustomerController@create');
    Route::get('customer/create', 'CustomerController@create');
    Route::post('customer/edit', 'CustomerController@edit');
    Route::get('customer/edit', 'CustomerController@edit');

    //Course_detail
    Route::post('course_detail/index', 'Course_detailController@grid');
    Route::get('course_detail/index', 'Course_detailController@grid');


    //Product
    Route::post('product/index', 'ProductController@grid');
    Route::get('product/index', 'ProductController@grid');

    Route::post('product/create', 'ProductController@create');
    Route::get('product/create', 'ProductController@create');

    //End Product

    //Order
    Route::post('order/index', 'OrderController@grid');
    Route::get('order/index', 'OrderController@grid');
    Route::post('order/create', 'OrderController@create');
    Route::get('order/create', 'OrderController@create');
    //End Order

    //Product_detail
    Route::post('product_detail/index', 'Product_detailController@grid');
    Route::get('product_detail/index', 'Product_detailController@grid');
    //End Product_detail


    //Branch
    Route::post('branch/index', 'BranchController@grid');
    Route::get('branch/index', 'BranchController@grid');
    Route::post('branch/create', 'BranchController@create');
    Route::get('branch/create', 'BranchController@create');
    Route::any('branch/edit', 'BranchController@edit');
    //End Branch

    //Vendor
    Route::post('vendor/index', 'VendorController@grid');
    Route::get('vendor/index', 'VendorController@grid');
    Route::post('vendor/create', 'VendorController@create');
    Route::get('vendor/create', 'VendorController@create');
    //End Vendor

});

Route::get('/login',    'UserController@getLogin');
Route::get('user/logout',    'UserController@getLogout');


Route::post('/auth',   'UserController@auth');

Route::controller('admin','AdminController');
Route::controller('user','UserController');
