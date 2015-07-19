<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:12
 */

namespace App\Http\Controllers;

use App\Doctor;
use App\Dr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class DoctorController extends Controller
{

    public function calender(){
        return view("dr/calender");
    }

    public function getDataGrid(){
        $grid = DataGrid::source('doctor');
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('dr_id', 'รหัสหมอ',true)->style("width:110px");
        $grid->add('dr_name', 'ชื่อ');
        $grid->add('dr_lastname', 'นามสกุล');
        $grid->add('dr_tel', 'เบอร์โทรศัพท์');
        $grid->add('dr_sex', 'เพศ')->style("width:80x");
        $grid->edit('/dr/edit','กระทำ','show|modify|delete');
        $grid->link('dr/create',"เพิ่มข้อมูลใหม่", "TR");
        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $form = $this->create();
        $grid->row(function ($row) {
            if ($row->cell('dr_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('dr/index', compact('grid','form'));
    }


    public function create()
    {

        $form = DataEdit::source(new Doctor());
        $form->text('dr_name', 'ชื่อหมอ')->rule('required');
        $form->text('dr_lastname', 'นามสกุล')->rule('required');
        $form->text('dr_tel', 'เบอร์โทรศัพท์มือถือ')->rule('required');
        $form->text('dr_sex', 'เพศ')->rule('required')->options(Config::get('sex.sex'))->rule('required');
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->link("dr/index", "ย้อนกลับ");
        $form->saved(function () use ($form) {
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");
            $form->link("dr/index", "ย้อนกลับ");
        });
        return $form;
    }

   public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Doctor());
        $edit->link("branch/index","บันทึก", "TR")->back();
        $edit->text('dr_id', 'รหัสหมอ');
        $edit->text('dr_name', 'ชื่อหมอ');
        $edit->text('dr_lastname', 'นามสกุล');
        $edit->text('dr_tel', 'เบอร์โทรศัพท์มือถือ');
        $edit->text('dr_sex', 'เพศ')->options(Config::get('sex.sex'))->rule('required');
        $edit->attributes(array("class" => " "));
        $edit->link("dr/index", "ย้อนกลับ");
        return $edit->view('dr/edit', compact('edit'));
    }

}
