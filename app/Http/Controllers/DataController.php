<?php

namespace App\Http\Controllers;

use App\Course;
use App\Customer;
use App\Http\Requests;
use App\Product;
use App\User;
use App\Vendor;
use yajra\Datatables\Datatables;

class DataController extends Controller
{

    public function getCustomerList()
    {
        $query = '%' . \Input::get('q') . '%';
        $customer = Customer::
        where('cus_name', 'LIKE', $query)
            ->orWhere('cus_id', 'LIKE', $query)
            ->orWhere('cus_phone', 'LIKE', $query)
            ->get();
        return response()->json($customer);
    }

    public function getCustomerData()
    {
        $customer = Customer::select(['cus_id', 'cus_name', 'cus_tel'])->get();

        return Datatables::of($customer)
            ->addColumn('action', function ($customer) {
                return '<a href="' . url('customer/view') . '?cus_id=' . $customer->cus_id . '" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-edit"></i> ข้อมูลลูกค้า</a>';
            })
            ->addColumn("รายละเอียด", "รายละเอียด", false)
            ->make();

    }

    public function getUserList()
    {
        $query = '%' . \Input::get('q') . '%';
        $customer = User::select(['id', 'name'])
            ->where('id', 'LIKE', $query)
            ->orWhere('name', 'LIKE', $query)
            ->get();
        return response()->json($customer);
    }

    public function getProductList()
    {
        $product = Product::all();
        return response()->json($product);
    }

    public function productSearch()
    {
        $query = '%' . \Input::get('q') . '%';
        $vendor = Product::
        where('product_name', 'LIKE', $query)
            ->orWhere('product_id', 'LIKE', $query)
            ->get();
        return response()->json($vendor);
    }

    public function vendorSearch()
    {
        $query = '%' . \Input::get('q') . '%';
        $vendor = Vendor::
        where('ven_name', 'LIKE', $query)
            ->orWhere('ven_id', 'LIKE', $query)
            ->get();
        return response()->json($vendor);
    }

    public function getCourseList()
    {
        $query = '%' . \Input::get('q') . '%';
        $course = Course::
        with('detail')
            ->where('course_name', 'LIKE', $query)
            ->orWhere('course_id', 'LIKE', $query)
            ->get();

        //$course = Course::find(2);
        //dd($course);
        return response()->json($course);
    }

}
