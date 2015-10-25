<?php

namespace App\Http\Controllers;

use App\Course_type;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class Course_typeController extends Controller
{
    public function index()
    {
        return view("course_type");
    }

    public function getDataGrid()
    {
        $grid = DataGrid::source(new Course_type());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('ct_id', 'รหัสประเภทคอร์ส');
        $grid->add('name', 'ชื่อประเภทคอร์ส');
        $grid->edit('/course_type/edit', 'กระทำ','modify|delete');


        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $form = $this->create();

        return view('course_type/course_type', compact('form','grid'));
    }
    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataEdit::source(new Course_type());
        $form->text('name', 'ชื่อประเภทคอร์ส')->rule('required|unique:course_type,ct_id')->attributes(array('placeholder'=>'....'));
        $form->attributes(array("class" => " "));
        $form->saved(function () use ($form) {
            $form->message("เสร็จสิ้น");
            $form->link("course_type", "กลับ");
            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Course_type',
                'description'=>'เพิ่มประเภทคอร์ส : รหัสประเภทคอร์ส '.$user->ct_id
            ]);
        });
        return view('course_type/course_type', compact('form','grid'));
    }
    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Course_type());
        $edit->text('name', 'ชื่อประเภทคอร์ส');
        $edit->attributes(array("class" => " "));
        $edit->link("course_type", "กลับ");
        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Course_type',
                'description'=>'แก้ไขประเภทคอร์ส : ประเภท '. Input::get('name')
            ]);

        });
        return $edit->view('course_type/edit', compact('edit'));


    }

}
