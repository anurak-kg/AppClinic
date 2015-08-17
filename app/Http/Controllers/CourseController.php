<?php
namespace App\Http\Controllers;
use App\Course;
use App\Medicine;
use App\Product;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataGrid;

class CourseController extends Controller
{
    public function getIndex()
    {
        $course = Course::all();

        return view("course/index",compact('course'));
    }
    public function getView()
    {
        $course = Course::where('course_id', \Input::get('course_id'))->with('product')->get();

        //return response()->json($course);
        return view("course/view", ['course' => $course[0]]);
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
        $grid->add('{{$course_id}}', 'รายละเอียด')->cell(function ($course_id) {
            return '<a href="' . url('/course/view') . '?course_id=' . $course_id . '" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-edit"></i> ข้อมูลคอร์ส</a>';
        });
        $grid->edit('/course/edit', 'กระทำ', 'modify');
        $grid->link('course/create', "เพิ่มข้อมูลใหม่", "TR");
        return $grid;
    }

    public function getCreate()
    {
        return view('course/create');
    }
    public function getDelete(){
        $course = Course::findOrFail(Input::get('course_id'));
        $course->delete();
        return redirect('course/index')->with('message', 'ลบคอร์สเรียบร้อยแล้ว');
    }
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required|unique:course,course_id',
            'course_name' => 'required',
            'course_detail' => 'required',
            'course_price' => 'required|numeric',
            'course_qty' => 'required|numeric|min:1',

        ]);

        $medicine = json_decode(Input::get('json'));
        $course = new Course();
        $course->course_id = Input::get('course_id');
        $course->course_name = Input::get('course_name');
        $course->course_detail = Input::get('course_detail');
        $course->course_price = Input::get('course_price');
        $course->course_qty = Input::get('course_qty');
        $course->save();
        if (count($medicine) != 0) {
            foreach ($medicine as $item) {
                $product = Product::find($item->product_id);
                $course->medicine()->attach($product, [
                    'qty' => $item->qty,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
                echo $item->product_id;
            }
        }
        //dd($medicine);
        //dd(Input::all());
        return redirect('course/create')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }
    public function postUpdate(){
        $course = Course::findOrFail(Input::get('course_id'));
        $course->course_name = Input::get('course_name');
        $course->course_detail = Input::get('course_detail');
        $course->course_price = Input::get('course_price');
        $course->course_qty = Input::get('course_qty');
        $course->save();
        return redirect('course/index')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }
    public function getEdit()
    {
        $course = Course::findOrFail(Input::get('modify'));
        return view('course/edit', compact('course'));
    }
    public function getMedicineData()
    {
        $medicine = Medicine::where('course_id', Input::get('course_id'))
            ->with('product')->get();
        $data = [];
        $index = 0;
        foreach ($medicine as $item) {
            $array['id'] = $index;
            $array['product_id'] = $item->product->product_id;
            $array['qty'] = $item->qty;
            $array['product_name'] = $item->product->product_name;
            array_push($data, $array);
            $index++;
        }
        return response()->json($data);
    }
    public function getMedicineAdd()
    {
        $medicine = new Medicine();
        $medicine->course_id = Input::get('course_id');
        $medicine->product_id = Input::get('product_id');
        $medicine->qty= Input::get('qty');
        $medicine->save();
    }
    public function getMedicineRemove()
    {
        $medicine = Medicine::where('course_id', Input::get('course_id'))
            ->where('product_id', Input::get('product_id'));
        $medicine->delete();
    }
}