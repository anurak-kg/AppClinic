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
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('branch_id', 'รหัสสาขา',true);
        $grid->add('branch_name', 'ชื่อสาขา',true);
        $grid->add('branch_address', 'ที่อยู่สาขา');
        $grid->add('branch_tel', 'เบอร์โทร');
        $grid->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี');
        $grid->edit('/branch/edit', 'กระทำ','show|modify|delete');
        $grid->link('branch/create',"เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('branch_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('branch/index', compact('grid'));
    }


    public function create()
    {

        $form = DataEdit::source(new Branch());
        $form->text('branch_name', 'ชื่อสาขา')->rule('required')->attributes(array('placeholder'=>'โปรดระบุชื่อสาขา....'));
        $form->textarea('branch_address', 'ที่อยู่สาขา')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุที่อยู่สาขา....'));
        $form->text('branch_tel', 'เบอร์โทร')->rule('required')->attributes(array('placeholder'=>'โปรดระบุเบอร์โทรสาขา....'));
        $form->text('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี')->rule('required')->attributes(array('placeholder'=>'โปรดระบุหมายเลขประจำตัวผู้เสียภาษี....'));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("branch/index", "ย้อนกลับ");
        });

        return view('branch/create', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Branch());
        $edit->text('branch_name', 'ชื่อสาขา');
        $edit->textarea('branch_address', 'ที่อยู่สาขา');
        $edit->text('branch_tel', 'เบอร์โทร');
        $edit->text('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี');
        $edit->attributes(array("class" => " "));
        $edit->link("branch/index", "ย้อนกลับ");


        return $edit->view('branch/edit', compact('edit'));
    }

}
