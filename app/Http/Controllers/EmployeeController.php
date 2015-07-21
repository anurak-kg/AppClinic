<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:12
 */

namespace App\Http\Controllers;

use App\Employee;
use App\Branch;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;


class EmployeeController extends Controller
{
    public function employee(){
        return view("employee/index");
    }


    public function getDataGrid(){
        $grid = DataGrid::source(Employee::with('branch'));
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('emp_id', 'รหัสพนักงาน',true);
        $grid->add('{{ $branch->branch_name }}', 'สาขา','branch_id');
        $grid->add('emp_name', 'ชื่อ',true);
        $grid->add('emp_lastname', 'นามสกุล',true);
        $grid->add('emp_position', 'ตำแหน่ง ',true);
        $grid->add('emp_tel', 'เบอร์โทร  ',true);
        $grid->add('emp_sex', 'เพศ ',true);
        $grid->edit('/employee/edit', 'การกระทำ','modify|delete');
        $grid->link('/employee/create',"เพิ่มข้อมูลใหม่", "TR");


        $grid->paginate(10);


        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('emp_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view("employee/index", compact('grid'));
    }


    public function create()
    {

        $form = DataEdit::source(new Employee());
        $form->add('branch_id', 'ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $form->text('emp_name', 'ชื่อพนักงาน')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุชื่อพนักงาน....'));;
        $form->text('emp_lastname', 'นามสกุล')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุนามสกุล....'));;
        $form->text('emp_position', 'ตำแหน่ง')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุตำแหน่ง....'));;
        $form->text('emp_tel', 'เบอร์โทร')->rule('required|numeric')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุเบอร์โทร....'));;
        $form->add('emp_sex', 'เพศ','select')->rule('required')->options(Config::get('sex.sex'))->rule('required');
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("employee/index", "ย้อนกลับ");
        });

        return view("employee/create", compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Employee());
        $edit->add('branch_id', 'ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $edit->text('emp_name', 'ชื่อพนักงาน');
        $edit->text('emp_lastname', 'นามสกุล');
        $edit->text('emp_position', 'ตำแหน่ง');
        $edit->text('emp_tel', 'เบอร์โทร');
        $edit->add('emp_sex', 'เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $edit->attributes(array("class" => " "));
        $edit->link("employee/index", "ย้อนกลับ");
        return $edit->view('employee/edit', compact('edit'));
    }

}
