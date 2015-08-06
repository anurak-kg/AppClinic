<?php

namespace App\Http\Controllers;

use App\Course;
use App\Product;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function course()
    {
        return view("course/index");
    }

    public function getDataGrid()
    {
        $grid = DataGrid::source(new Course());
        $grid->attributes(array("class" => "table table-hover"));
        $grid->attributes(array("class" => "table table-bordered"));
        $grid->add('course_id', 'รหัสคอร์ส');
        $grid->add('course_name', 'ชื่อคอร์ส');
        $grid->add('course_qty', 'จำนวน');
        $grid->add('course_price', 'ราคา');
        $grid->edit('/course/edit', 'กระทำ', 'modify');
        $grid->link('course/create', "เพิ่มข้อมูลใหม่", "TR");
        return $grid;
    }

    public function grid()
    {

        $grid = $this->getDataGrid();

        return view('course/index', compact('grid'));
    }

    public function create()
    {
        return view('course/create');
    }

    public function postCourse()
    {

        $course = new Course();
        $course->course_id = Input::get('course_id')->rule('unique:course,course_id');
        $course->course_name = Input::get('course_name');
        $course->course_detail = Input::get('comment');
        $course->course_price = Input::get('course_price')->rule('required|numeric');
        $course->course_qty = Input::get('course_qty')->rule('required|numeric');
        $course->save();
        $medicine = json_decode(Input::get('json'));
        //dd($medicine);
        echo $course->course_id;
        foreach ($medicine as $item) {

            $product = Product::find($item->product_id);
            $course->medicine()->attach($product, [
                'qty' => $item->qty,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

            ]);

            echo $item->product_id;
        }
        //dd(Input::all());
        return redirect('course/create')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');

    }


    public function edit()
    {
        if (Input::get('do_delete') == 1) return "not the first";

        $edit = DataEdit::source(new Course());
        $edit->text('course_name', 'ชื่อคอร์ส');
        $edit->text('comment','รายละเอียดเพิ่มเติม');
        $edit->text('course_price','ราคา');
        $edit->text('course_qty','จำนวน');
        $edit->attributes(array("class" => " "));
        $edit->link("course/index", "ย้อนกลับ");

        return $edit->view('course/edit', compact('edit'));
    }
    public function removemedicine()
    {
        $quo = Course::findOrFail('course_id');
        $quo->product_id = 0;
        $quo->save();
    }

}
