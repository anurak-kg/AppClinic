<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:12
 */

namespace App\Http\Controllers;

use App\Dr;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class DoctorController extends Controller
{
    public function doctor(){
        return view("dr/index");
    }


    public function getDataGrid(){
        $grid = DataGrid::source('doctor');
        $grid->add('dr_id', 'รหัสหมอ',true)->style("width:110px");
        $grid->add('dr_name', 'ชื่อหมอ');
        $grid->add('dr_lastname', 'นามสกุล');
        $grid->add('dr_tel', 'เบอร์โทรศัพท์มือถือ');
        $grid->add('dr_sex', 'เพศ')->style("width:80x");
        $grid->edit('/dr/edit', 'การกระทำ','modify|delete');
        $grid->link('dr/create',"เพิ่มข้อมูลใหม่", "TR");
        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('dr_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('dr/index', compact('grid'));
    }


    public function create()
    {

        $grid = $this->getDataGrid();
        $form = DataForm::create();
        $form->text('dr_id', 'รหัสหมอ')->rule('required');
        $form->text('dr_name', 'ชื่อหมอ')->rule('required');
        $form->text('dr_lastname', 'นามสกุล')->rule('required');
        $form->text('dr_tel', 'เบอร์โทรศัพท์มือถือ')->rule('required');
        $form->text('dr_sex', 'เพศ')->rule('required');
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->link("dr/index", "ย้อนกลับ");

        $form->saved(function () use ($form) {
            $user = new Dr\doctor();
            $user->dr_id = Input::get('dr_id');
            $user->dr_name = Input::get('dr_name');
            $user->dr_lastname = Input::get('dr_lastname');
            $user->dr_tel = Input::get('dr_tel');
            $user->dr_sex = Input::get('dr_sex');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");
            $form->link("dr/manage", "ย้อนกลับ");
        });
        return view('dr/create', compact('form'));
    }

   /* public function edit() {
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
