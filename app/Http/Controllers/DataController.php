<?php

namespace App\Http\Controllers;

use App\Course;
use App\Customer;
use App\Http\Requests;
use App\User;

class DataController extends Controller
{

    public function getCustomerList()
    {
        $query = '%' . \Input::get('q') . '%';
        $customer = Customer::
            where('cus_name', 'LIKE', $query)
            ->orWhere('cus_id', 'LIKE', $query)
            ->orWhere('cus_lastname', 'LIKE', $query)
            ->orWhere('cus_phone', 'LIKE', $query)
            ->get();
        return response()->json($customer);
    }

    public function getUserList()
    {
        $query = '%' . \Input::get('q') . '%';
        $customer = User::select(['id','name'])
            ->where('id', 'LIKE', $query)
            ->orWhere('name', 'LIKE', $query)
            ->get();
        return response()->json($customer);
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
