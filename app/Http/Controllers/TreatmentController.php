<?php

namespace App\Http\Controllers;

use App\Course;
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
    public function treatment(){
        return veiw("treatment/index");
    }
    public function getDataGrid()
    {
        $grid = DataGrid::source(Treatment::with('course','user','customer'));
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));

        $grid->add('{{ $user->name }}', 'ชื่อพนักงาน','id');
        $grid->add('{{ $customer->cus_name }}', 'ชื่อลูกค้า','emp_id');
        $grid->add('{{ $course->course_name }}', 'ชื่อคอร์ส','course_id');
        $grid->add('tre_qty', 'จำนวนครั้งที่รักษา');
        $grid->add('created_at', 'วันที่รับการรักษา');
        $grid->link('treatment/create',"เข้ารับการรักษา", "TR");

        $grid->paginate(10);
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('tre_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('treatment/index', compact('grid'));
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = DataEdit::source(new Treatment());
        $form->add('cus_id','ชื่อลูกค้า','select')->options(Customer::lists('cus_name','cus_id')->toArray());
        $form->add('id','พนักงาน','select')->options(User::lists('name','id')->toArray());
        $form->add('course_id','ชื่อคอร์ส','select')->options(Course::lists('course_name','course_id')->toArray());
        $form->text('tre_qty','จำนวนครั้งที่รักษา')->rule('required|numeric');

        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("treatment/index", "ย้อนกลับ");
        });
        $form->build();
        return view('treatment/create', compact('form'));

    }

    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Treatment());
        $edit->add('cus_id','ชื่อลูกค้า','select')->options(Customer::lists('cus_name','cus_id')->toArray());
        $edit->add('course_id','ชื่อคอร์ส','select')->options(Course::lists('course_name','course_id')->toArray());
        $edit->text('tre_qty','จำนวนครั้งที่รักษา')->rule('required|numeric');
        $edit->add('id','พนักงาน','select')->options(User::lists('name','id')->toArray());


        $edit->attributes(array("class" => " "));


        return $edit->view('treatment/edit', compact('edit'));
    }


}
