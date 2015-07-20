<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function course(){
        return view("course/index");
    }

    public function getDataGrid(){
        $grid = DataGrid::source('course');
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('course_id', 'รหัส',true);
        $grid->add('course_name', 'ชื่อคอร์ส');
        $grid->add('course_type', 'ประเภทคอร์ส');
        $grid->edit('/course/edit', 'กระทำ','modify|delete');
        $grid->link('course/create',"เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('course_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('course/index', compact('grid'));
    }

    public function create()
    {
        $form = DataEdit::create();
        $form->text('course_id', 'รหัส')->rule('required')->attributes(array('maxlength'=>4,'placeholder'=>'โปรดระบุรหัสคอร์ส....'));;
        $form->text('course_name', 'ชื่อคอร์ส')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุชื่อคอร์ส....'));;
        $form->text('course_type', 'ประเภทคอร์ส')->rule('required')->attributes(array('maxlength'=>30,'placeholder'=>'โปรดระบุประเภทคอร์ส....'));;
        $form->attributes(array("class" => " "));


        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("course/index", "ย้อนกลับ");
        });
        return view('course/create', compact('form'));
    }


    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Course());

        $edit->text('course_id', 'รหัส');
        $edit->text('course_name', 'ชื่อคอร์ส');
        $edit->text('course_type', 'ประเภทคอร์ส');
        $edit->attributes(array("class" => " "));

        return $edit->view('course/edit', compact('edit'));
    }


}
