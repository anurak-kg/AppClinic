<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Quotations;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class QuotationsController extends Controller
{

    public function getDataGrid(){
        $grid = DataGrid::source('quotations');
        $grid->attributes(array("class"=>"table table-striped"));
        $grid->add('quo_id', 'รหัสใบเสนอราคา',true);
        $grid->add('cus_id', 'รหัสสมาชิก',true);
        $grid->add('emp_id', 'รหัสพนักงาน');
        $grid->add('quo_date', 'วันที่เสนอ');
        $grid->add('quo_status', 'สถานะ');
        $grid->edit('/quotations/edit', 'กระทำ','modify|delete');
        $grid->link('quotations/create',"เพิ่มข้อมูลใหม่", "TR");
        $grid->paginate(10);

        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('quo_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('quotations/index', compact('grid'));
    }


    public function create()
    {
        $form = DataForm::create(new Quotations());
        $form->text('quo_id', 'รหัสใบเสนอราคา')->rule('required')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุ รหัสใบเสนอราคา....'));
        $form->text('cus_id', 'รหัสสมาชิก')->rule('required')->attributes(array('maxlength'=>30,'placeholder'=>'โปรดระบุ รหัสสมาชิก....'));
        $form->text('emp_id', 'รหัสพนักงาน')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุ รหัสพนักงาน....'));
        $form->text('quo_date', 'วันที่เสนอ')->rule('required')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุเบอร์โทรสาขา....'));
        $form->text('quo_status', 'สถานะ')->rule('required');
        $form->attributes(array("class" => " "));

        $form->submit('บันทึก');
        $form->link("quotations/index", "ย้อนกลับ");

        $form->saved(function () use ($form) {
            $user = new Branch();
            $user->branch_id = Input::get('branch_id');
            $user->branch_name = Input::get('branch_name');
            $user->branch_address = Input::get('branch_address');
            $user->branch_tel = Input::get('branch_tel');
            $user->branch_code = Input::get('branch_code');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");
            $form->link("quotations/index", "ย้อนกลับ");
        });

        return view('quotations/create', compact('form'));
    }

    /*public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source('branch');
        $edit->link("branch/index","บันทึก", "TR")->back();


        $edit->add('branch_id', 'รหัสสาขา','text');
        $edit->add('branch_name', 'ชื่อสาขา','text');
        $edit->add('branch_address', 'ที่อยู่สาขา','textarea');
        $edit->add('branch_tel', 'เบอร์โทร','text');
        $edit->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี','text');


        return $edit->view('branch/edit', compact('edit'));
    }
 */
}
