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
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;


class EmployeeController extends Controller
{
    public function employee(){
        return view("employee/index");
    }


    public function getDataGrid(){
        $grid = DataGrid::source(Employee::with('branch'));
        $grid->attributes(array("class"=>"table table-striped"));
        $grid->add('emp_id', 'รหัสพนักงาน',true);
        $grid->add('{{ $branch->branch_name }}', 'สาขา','branch_id');
        $grid->add('emp_name', 'ชื่อพนักงาน',true);
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

        $form = DataForm::create();
        $form->text('emp_id', 'รหัสพนักงาน')->rule('required')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุรหัสสาขา....'));
        $form->add('branch_id', 'ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id'));
        $form->textarea('emp_name', 'ชื่อพนักงาน')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุที่อยู่สาขา....'));
        $form->text('emp_lastname', 'นามสกุล')->rule('required')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุเบอร์โทรสาขา....'));
        $form->text('emp_position', 'ตำแหน่ง')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุตำแหน่ง....'));
        $form->text('emp_tel', 'เบอร์โทร')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุเบอร์โทร....'));
        $form->add('emp_sex', 'เพศ','select')->rule('required')->attributes(array('maxlength'=>13))->option('A','โปรดเลือก...')->option('M','ชาย')->option('F','หญิง');
        $form->attributes(array("class" => " "));

        $form->submit('บันทึก');
        $form->link("employee/index", "ย้อนกลับ");
        $form->saved(function () use ($form) {
            $user = new Employee();
            $user->emp_id = Input::get('emp_id');
           $user->branch_id = Input::get('branch_id');
            $user->emp_name = Input::get('emp_name');
            $user->emp_lastname = Input::get('emp_lastname');
            $user->emp_position = Input::get('emp_position');
            $user->emp_tel = Input::get('emp_tel');
            $user->emp_sex = Input::get('emp_sex');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");
            $form->link("employee/index", "ย้อนกลับ");
        });

        return view("employee/create", compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source('employee');
        $edit->link("branch/manage","บันทึก", "TR")->back();

        $edit->add('branch_id', 'รหัสสาขา','text');
        $edit->add('branch_name', 'ชื่อสาขา','text');
        $edit->add('branch_address', 'ที่อยู่สาขา','textarea');
        $edit->add('branch_tel', 'เบอร์โทร','text');
        $edit->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี','text');


        return $edit->view('branch/edit', compact('edit'));
    }

}
