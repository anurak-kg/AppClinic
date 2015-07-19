<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
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
        $form = DataForm::create();
        $form->text('course_id', 'รหัส')->rule('required');
        $form->text('course_name', 'ชื่อคอร์ส')->rule('required');
        $form->text('course_type', 'ประเภทคอร์ส')->rule('required');
        $form->attributes(array("class" => " "));

        $form->submit('บันทึก');
        $form->link("course/index", "ย้อนกลับ");
        $form->saved(function () use ($form) {
            $user = new Course();
            $user->course_id = Input::get('course_id');
            $user->course_name = Input::get('course_name');
            $user->course_type = Input::get('course_type');
            $user->save();
            $form->message("ok");

        });
        return view('course/create', compact('form'));
    }

}
