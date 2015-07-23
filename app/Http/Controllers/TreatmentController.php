<?php

namespace App\Http\Controllers;

use App\Course;
use App\Doctor;
use App\Quotations_detail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Query;
use App\Quotations;
use App\Customer;
use App\Treatment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function treatment()
    {
        return view("treatment/index");
    }

    public function getCourseData()
    {
        $customerId =\Input::get('id');
        $course =Quotations::with('course')
            ->where('cus_id', '=',$customerId)
            ->where('quo_status','>=',1)
            ->get();
        return response()->json($course);
    }

    public function add()
    {
        $course_id = \Input::get('course_id');
        $quo_id = \Input::get('quo_id');
        $quo = Quotations_detail::with(['Course','Quotations.Customer'])
            ->where('quo_id','=',$quo_id)
            ->where('course_id','=',$course_id)
            ->get();
        $dr = Doctor::all();
        $user = User::all();
        //return response()->json($quo);
        return view('treatment.add',
            ['quo'      =>    $quo[0],
            'doctor'    =>      $dr,
            'users'     => $user
        ]);
    }



}
