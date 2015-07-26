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
    Route::any('user/edit', 'UserController@edit');

    Route::post('user/adddoctor', 'UserController@adddoctor');
    Route::get('user/adddoctor', 'UserController@adddoctor');

    Route::any('user/editdoc', 'UserController@editdoc');
    //Course
    Route::post('course/index', 'CourseController@create');
    Route::get('course/index', 'CourseController@create');
    Route::post('course/create', 'CourseController@create');
    Route::get('course/create', 'CourseController@create');
    Route::any('course/edit', 'CourseController@edit');
    //End Course

    //Course
    Route::post('receive/index', 'ReceiveController@grid');
    Route::get('receive/index', 'ReceiveController@grid');
    Route::post('receive/create', 'ReceiveController@create');
    Route::get('receive/create', 'ReceiveController@create');
    Route::any('receive/edit', 'ReceiveController@edit');
    //End Course

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
    Route::post('dr/calender', 'Doctor_eventController@create');
    Route::get('dr/calender', 'Doctor_eventController@create');
    //Doctor calender
    Route::get('doctor_calender/fetch/', 'Doctor_eventController@fetch');
    Route::get('doctor_calender/update/', 'Doctor_eventController@update');
    Route::get('doctor_calender/delete/', 'Doctor_eventController@delete');

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
    Route::get('treatment','TreatmentController@treatment');
    Route::get('treatment/course_data','TreatmentController@getCourseData');
    Route::get('treatment/add','TreatmentController@add');
    Route::post('treatment/save','TreatmentController@save');


    //Quotations
    Route::post('quotations','QuotationsController@index');
    Route::get('quotations','QuotationsController@index');
    Route::get('quotations/query', 'QuotationsController@getCustomerList');
    Route::get('quotations/course_query', 'QuotationsController@getCourseList');
    Route::get('quotations/update', 'QuotationsController@update');
    Route::get('quotations/add', 'QuotationsController@add');
    Route::get('quotations/delete', 'QuotationsController@delete');
    Route::get('quotations/data', 'QuotationsController@getData');
        //---customer script
        Route::get('quotations/data_customer', 'QuotationsController@getDataCustomer');
        Route::get('quotations/set_customer', 'QuotationsController@setCustomer');
        Route::get('quotations/remove_customer', 'QuotationsController@removeCustomer');
        //---sale script
        Route::get('quotations/data_sale', 'QuotationsController@getDataSale');
        Route::get('quotations/set_sale', 'QuotationsController@setSale');
        Route::get('quotations/remove_sale', 'QuotationsController@removeSale');
    Route::get('quotations/save', 'QuotationsController@save');

    //Customer
    Route::post('customer', 'CustomerController@grid');
    Route::get('customer', 'CustomerController@grid');
    Route::post('customer/create', 'CustomerController@create');
    Route::get('customer/create', 'CustomerController@create');
    Route::post('customer/edit', 'CustomerController@edit');
    Route::get('customer/edit', 'CustomerController@edit');
    Route::any('customer/edit', 'CustomerController@edit');
    Route::post('customer/calendar', 'Customer_eventController@create');
    Route::get('customer/calendar', 'Customer_eventController@create');
    //Customer calender
    Route::get('customer_calendar/fetch/', 'Customer_eventController@fetch');
    Route::get('customer_calendar/update/', 'Customer_eventController@update');
    Route::get('customer_calendar/delete/', 'Customer_eventController@delete');

    //Course_detail
    Route::post('course_detail/index', 'Course_detailController@grid');
    Route::get('course_detail/index', 'Course_detailController@grid');

    //Product
    Route::post('product/index', 'ProductController@grid');
    Route::get('product/index', 'ProductController@grid');
    Route::post('product/create', 'ProductController@create');
    Route::get('product/create', 'ProductController@create');
    Route::any('product/edit', 'ProductController@edit');

    //Order
    Route::get('order/index', 'OrderController@z');
    Route::post('order/create', 'OrderController@create');
    Route::get('order/create', 'OrderController@create');
    Route::any('order/edit', 'OrderController@edit');

    //Product_detail
    Route::post('product_detail/index', 'Product_detailController@grid');
    Route::get('product_detail/index', 'Product_detailController@grid');


    //Branch
    Route::post('branch/index', 'BranchController@create');
    Route::get('branch/index', 'BranchController@create');
    Route::post('branch/create', 'BranchController@create');
    Route::get('branch/create', 'BranchController@create');
    Route::any('branch/edit', 'BranchController@edit');


    //Vendor
    Route::post('vendor/index', 'VendorController@create');
    Route::get('vendor/index', 'VendorController@create');
    Route::post('vendor/create', 'VendorController@create');
    Route::get('vendor/create', 'VendorController@create');
    Route::any('vendor/edit', 'VendorController@edit');


    Route::post('bill/bill', 'BillController@index');
    Route::get('bill/bill', 'BillController@index');

    // Ajax Data Controller
    Route::get('data/customer_search', 'DataController@getCustomerList');
    Route::get('data/user_search', 'DataController@getUserList');
    Route::get('data/customer', 'DataController@getCustomerData');

    //Report
    Route::get('report/doctor', 'ReportController@reportDoctorTest');
    Route::get('report/sale', 'ReportController@reportSalesTest');
    Route::get('report/coursemonth', 'ReportController@reportCourseMonthTest');
    Route::get('report/coursehot', 'ReportController@reportCourseHotTest');


});

Route::get('/login',    'UserController@getLogin');
Route::get('user/logout',    'UserController@getLogout');


Route::post('/auth',   'UserController@auth');

Route::controller('admin','AdminController');
Route::controller('user','UserController');
Route::get('faker', function () {
 echo factory('App\Customer',50)->create();

});
