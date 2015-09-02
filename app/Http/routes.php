<?php

Route::group(['middleware' => 'permission:quo'], function () {
    Route::controller('quotations', 'QuotationsController');
    Route::any('bill/bill', 'BillController@index');
});

//Treatment
Route::group(['middleware' => 'permission:treatment'], function () {
    Route::get('treatment', 'TreatmentController@treatment');
    Route::get('treatment/course_data', 'TreatmentController@getCourseData');
    Route::get('treatment/add', 'TreatmentController@add');
    Route::get('treatment/product-list', 'TreatmentController@getProductList');
    Route::get('treatment/medicine-remain', 'TreatmentController@getMedicineRemain');

    Route::post('treatment/save', 'TreatmentController@save');
});

//Customer
Route::group(['middleware' => 'permission:customer-read'], function () {
    Route::any('customer','CustomerController@index');
    Route::any('customer/view','CustomerController@view');
    // Ajax Data Controller
    Route::get('data/customer_search', 'DataController@getCustomerList');
    Route::get('data/user_search', 'DataController@getUserList');
    Route::get('data/customer', 'DataController@getCustomerData');
    Route::get('data/product', 'DataController@getProductList');
    Route::get('data/vendor_search', 'DataController@vendorSearch');
});
Route::group(['middleware' => 'permission:customer-edit'], function () {
    Route::any('customer/edit','CustomerController@edit');
    Route::get('customer/upload','CustomerController@upload');
    Route::get('customer/photo-data','CustomerController@getJsonPhotoList');
    Route::post('customer/upload','CustomerController@uploadFiles');
    Route::post('customer/photo-delete','CustomerController@getDeletePhotoById');

});
Route::any('customer/create', ['uses' => 'CustomerController@create', 'middleware' => 'permission:customer-create']);
Route::any('report/salesperday', ['uses' => 'ReportController@reportsalesperday', 'middleware' => 'permission:customer-create']);
Route::any('report/commissionCash', ['uses' => 'ReportController@reportCommissionCash', 'middleware' => 'permission:customer-create']);
Route::any('report/commissionCredit', ['uses' => 'ReportController@reportCommissionCredit', 'middleware' => 'permission:customer-create']);
Route::any('customer/delete', ['uses' => 'CustomerController@delete', 'middleware' => 'permission:customer-delete']);

//Employee
Route::group(['middleware' => 'permission:emp'], function () {
    Route::any('user/edit','UserController@edit');
    Route::get('user/resetpassword','UserController@resetPass');
    Route::post('user/resetpassword','UserController@postResetPassword');
    Route::any('user/editdoc','UserController@editdoc');
    Route::any('user/manage', 'UserController@manage');
    Route::any('user/adddoctor','UserController@adddoctor');
});


//order
Route::group(['middleware' => 'permission:order-order'], function () {
    //Route::any('order/history', 'OrderController@history');
    Route::controller('order', 'OrderController');
    Route::controller('request', 'RequestController');

    Route::any('bill/order', 'BillController@order');
    Route::any('bill/request', 'BillController@request');

});

//Receive
Route::group(['middleware' => 'permission:receive-return'], function () {
    Route::controller('receive', 'ReceiveController');
    Route::controller('receive-request', 'ReceiveRequestController');
    Route::controller('return', 'ReturnController');
});

//Course
Route::group(['middleware' => 'permission:course'], function () {
    Route::controller('course', 'CourseController');
});
Route::group(['middleware' => 'permission:course-read'], function () {
    Route::any('course/index', 'CourseController@getIndex');
    Route::any('course/view', 'CourseController@getView');
});

//Product group
Route::group(['middleware' => 'permission:product-group'], function () {
    Route::any('product_group/index', 'Product_groupController@grid');
    Route::any('product_group/create', 'Product_groupController@create');
    Route::any('product_group/edit', 'Product_groupController@edit');
});

//Course type
Route::group(['middleware' => 'permission:course-type'], function () {
    Route::any('course_type', 'Course_typeController@grid');
    Route::any('course_type/edit', 'Course_typeController@edit');
});

//Dr
Route::group(['middleware' => 'permission:dr-working'], function () {
    Route::any('dr/calender','Doctor_eventController@create');
    //Doctor calender
    Route::get('doctor_calender/fetch/', 'Doctor_eventController@fetch');
    Route::get('doctor_calender/update/', 'Doctor_eventController@update');
    Route::get('doctor_calender/delete/', 'Doctor_eventController@delete');
});

//ตารางนัด
Route::group(['middleware' => 'permission:appointment'], function () {
    Route::any('customer/calendar','Customer_eventController@create');
    //Customer calender
    Route::get('customer_calendar/fetch/', 'Customer_eventController@fetch');
    Route::get('customer_calendar/update/', 'Customer_eventController@update');
    Route::get('customer_calendar/delete/', 'Customer_eventController@delete');

});

//Product
Route::group(['middleware' => 'permission:product'], function () {
    Route::any('product/create', 'ProductController@create');
    Route::any('product/expday', 'ProductController@expday');
    Route::any('product/stock', 'ProductController@stock');
    Route::any('product/stockmanage', 'ProductController@stockmanage');
    Route::any('product/edit', 'ProductController@edit');
});

Route::any('product/index', ['uses' =>  'ProductController@grid', 'middleware' => 'permission:product-read']);

//Branch
Route::group(['middleware' => 'permission:branch'], function () {
    Route::any('branch/index', 'BranchController@getDataGrid');
    Route::any('branch/edit', 'BranchController@edit');
});

//Vendor
Route::group(['middleware' => 'permission:vendor'], function () {
    Route::any('vendor/index', 'VendorController@create');
    Route::any('vendor/create', 'VendorController@create');
    Route::any('vendor/edit', 'VendorController@edit');
});

//Report
Route::group(['middleware' => 'permission:report'], function () {
    Route::any('report/doctor', 'ReportController@reportDoctorTest');
    Route::any('report/sale', 'ReportController@reportSalesTest');
    Route::any('report/coursemonth', 'ReportController@reportCourseMonthTest');
    Route::any('report/coursehot', 'ReportController@reportCourseHotTest');
    Route::any('report/producthot', 'ReportController@reportProductHot');
    Route::any('report/customer_ref', 'ReportController@reportCustomerref');
    Route::any('report/suplier', 'ReportController@reportsuplier');
    Route::any('report/request', 'ReportController@reportRequest');
    Route::any('report/customer_payment', 'ReportController@reportCustomer_payment');
    Route::any('money/manage', 'MoneyController@moneyDr');
    Route::any('log/index', 'SystemLogsController@index');
});

Route::group(['middleware' => 'permission:sales'], function () {
    Route::controller('sales', 'SalesController');
    Route::any('bill/billproduct', 'BillController@printBillSaleToHtml');
});
Route::group(['middleware' => 'permission:payment'], function () {
    Route::controller('payment', 'PaymentController');
});
Route::group(['middleware' => 'permission:setting'], function () {
    Route::controller('setting', 'SettingController');
});
Route::group(['middleware' => 'permission:permission'], function () {
    Route::any('branch/create', 'BranchController@create');
    Route::controller('permission', 'RoleController');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@dashboard');
});


Route::get('/login', 'UserController@getLogin');
Route::get('user/logout', 'UserController@getLogout');
Route::post('/auth', 'UserController@auth');

Route::controller('admin', 'AdminController');
Route::controller('user', 'UserController');
Route::get('test', function () {
    /*echo factory('App\Customer', 50)->create();
    echo factory('App\User', 20)->create();*/
   $ph = getNewCustomerPK();
    $count = strlen((string)$ph);
    dump([getNewPaymentPK(),getNewPaymentDetailPK()]);
});
