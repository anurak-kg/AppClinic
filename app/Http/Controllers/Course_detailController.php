<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 16/7/2558
 * Time: 19:35
 */

namespace App\Http\Controllers;

use App\Course_detail;
use App\Customer;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class Course_detailController extends Controller
{
    public function index()
    {


    }


    public function getDataGrid()
    {
        $grid = DataGrid::source('course_detail');
        $grid->attributes(array("class" => "table table-striped"));
        $grid->add('course_de_id', 'ลำดับที่', true);
        $grid->add('course_name', 'ชื่อคอร์ส', true);
        $grid->add('course_de_name', 'รายละเอียดคอร์ส');
        $grid->add('course_de_qty', 'จำนวนครั้งที่รับบริการ');
        $grid->add('course_de_date_start', 'วันที่เริ่ม');
        $grid->add('course_de_date_end', 'วันที่สิ้นสุด ');
        $grid->paginate(10);
        return $grid;
    }

    public function grid()
    {

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('course_de_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('course_detail/index', compact('grid'));
    }


    public function create()
    {
        $form = DataForm::create();
        $form->text('branch_id', 'รหัสสาขา')->rule('required')->attributes(array('maxlength' => 3, 'placeholder' => 'โปรดระบุรหัสสาขา....'));
        $form->text('branch_name', 'ชื่อสาขา')->rule('required')->attributes(array('maxlength' => 30, 'placeholder' => 'โปรดระบุชื่อสาขา....'));
        $form->textarea('branch_address', 'ที่อยู่สาขา')->rule('required')->attributes(array('rows' => 4, 'placeholder' => 'โปรดระบุที่อยู่สาขา....'));
        $form->text('branch_tel', 'เบอร์โทร')->rule('required')->attributes(array('maxlength' => 10, 'placeholder' => 'โปรดระบุเบอร์โทรสาขา....'));
        $form->text('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี')->rule('required')->attributes(array('maxlength' => 13, 'placeholder' => 'โปรดระบุหมายเลขประจำตัวผู้เสียภาษี....'));
        $form->attributes(array("class" => " "));

        $form->submit('บันทึก');
        $form->link("branch/index", "ย้อนกลับ");

        $form->saved(function () use ($form) {
            $user = new Branch();
            $user->branch_id = Input::get('branch_id');
            $user->branch_name = Input::get('branch_name');
            $user->branch_address = Input::get('branch_address');
            $user->branch_tel = Input::get('branch_tel');
            $user->branch_code = Input::get('branch_code');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");

        });

        return view('branch/create', compact('form'));
    }

    public function edit()
    {
        if (Input::get('do_delete') == 1) return "not the first";

        $edit = DataEdit::source('branch');
        $edit->link("branch/index", "บันทึก", "TR")->back();


        $edit->add('branch_id', 'รหัสสาขา', 'text');
        $edit->add('branch_name', 'ชื่อสาขา', 'text');
        $edit->add('branch_address', 'ที่อยู่สาขา', 'textarea');
        $edit->add('branch_tel', 'เบอร์โทร', 'text');
        $edit->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี', 'text');


        return $edit->view('branch/edit', compact('edit'));
    }

}
