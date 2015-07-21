<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Query;
use App\Quotations;
use App\Employee;
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
        $grid = DataGrid::source(Treatment::with('quotations','employee','customer'));
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('{{ $quotations->quo_id }}', 'ใบเสนอราคาเลขที่','quo_id');
        $grid->add('{{ $employee->emp_name }}', 'ชื่อพนักงาน','emp_id');
        $grid->add('{{ $customer->cus_name }}', 'ชื่อลูกค้า','cus_id');
        $grid->add('tre_id', 'เลขที่การรักษา');
        $grid->add('tre_date', 'วันที่รับการรักษา');
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
        $form->add('quo_id','เลขที่ใบเสนอราคา','select')->options(Quotations::lists('quo_id','quo_id')->toArray());
        $form->add('emp_id','พนักงาน','select')->options(Employee::lists('emp_name','emp_id')->toArray());
        $form->date('tre_date', 'วันที่มารับบริการ')->format('d/m/Y','th')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุวันที่เข้ามารับบริการ....'));;

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
        $edit->add('quo_id','เลขที่ใบเสนอราคา','select')->options(Quotations::lists('quo_id','quo_id')->toArray());
        $edit->add('emp_id','พนักงาน','select')->options(Employee::lists('emp_name','emp_id')->toArray());
        $edit->date('tre_date', 'วันที่มารับบริการ')->format('d/m/Y','th');

        $edit->attributes(array("class" => " "));


        return $edit->view('treatment/edit', compact('edit'));
    }


}
