<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class BranchController extends Controller
{

    public function getDataGrid(){
        $grid = DataGrid::source(new Branch());
        $grid->attributes(array("class"=>"table table-bordered",'id'=>'data-table'));

        $grid->add('branch_id', 'รหัสสาขา');
        $grid->add('branch_name', 'ชื่อสาขา');
        $grid->add('branch_address', 'ที่อยู่สาขา');
        $grid->add('branch_tel', 'เบอร์โทร');
        $grid->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี');
        $grid->edit('/branch/edit', 'กระทำ','modify|delete');
        $grid->link('branch/create', "เพิ่มข้อมูลใหม่", "TR");
        return view('branch/index', compact('grid'));
    }

    public function grid(){

        $grid = $this->getDataGrid();

        return view('branch/index', compact('grid'));
    }


    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataEdit::source(new Branch());
        $form->text('branch_name', 'ชื่อสาขา')->rule('required|unique:branch,branch_name')->attributes(array('maxlength'=>30,'placeholder'=>'โปรดระบุชื่อสาขา....'));
        $form->textarea('branch_address', 'ที่อยู่สาขา')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุที่อยู่สาขา....'));
        $form->text('branch_tel', 'เบอร์โทร')->rule('required')->attributes(array('placeholder'=>'โปรดระบุเบอร์โทรสาขา....'));
        $form->text('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี')->rule('required|numeric|unique:branch,branch_code')->attributes(array('maxlength'=>13,'minlength'=>13,'placeholder'=>'โปรดระบุหมายเลขประจำตัวผู้เสียภาษี....'));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $user = new Branch();
            $user->branch_id = Input::get('branch_id');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("branch/index", "ย้อนกลับ");

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Branch',
                'description'=>'เพิ่มข้อมูลสาขา : รหัสสาขา '.$user->branch_id
            ]);
        });

        return view('branch/create', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Branch());
        $edit->text('branch_name', 'ชื่อสาขา');
        $edit->textarea('branch_address', 'ที่อยู่สาขา')->attributes(array('rows'=>4));
        $edit->text('branch_tel', 'เบอร์โทร')->rule('numeric');
        $edit->text('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี')->rule('numeric')->attributes(array('maxlength'=>13,'minlength'=>13));
        $edit->attributes(array("class" => " "));
        $edit->link("branch/index", "ย้อนกลับ");
        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Branch',
                'description'=>'แก้ไขข้อมูลสาขา '.Input::get('branch_name')
            ]);
        });

        return $edit->view('branch/edit', compact('edit'));
    }

}
