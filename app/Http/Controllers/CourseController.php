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
        $grid->add('course_id', 'รหัสคอร์ส', true);
        $grid->add('course_name', 'ชื่อคอร์ส');
        $grid->edit('/course/edit', 'กระทำ', 'modify|delete');
        $grid->link('course/create', "เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);
        return $grid;
    }

    public function grid()
    {

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
        return view('course/create');
    }

    public function postCourse()
    {

        $course = new Course();
        $course->course_id = Input::get('course_id');
        $course->course_name = Input::get('course_name');
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

        $edit->text('course_id', 'รหัส');
        $edit->text('course_name', 'ชื่อคอร์ส');
        $edit->attributes(array("class" => " "));

        $edit->link("course/index", "ย้อนกลับ");

        return $edit->view('course/edit', compact('edit'));
    }


}
