<?php

namespace App\Http\Controllers;

use App\Allergic_detail;
use App\Course;
use App\User;
use App\Customer;
use App\Disease_detail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataForm;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;
use yajra\Datatables\Datatables;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer/index');
    }

    public function view()
    {
        $customer = Customer::with('Quotations.course')->where('cus_id',\Input::get('cus_id'))->get()->first();

        $data = \DB::table('treat_has_medicine')
            ->select('treat_history.treat_id','treat_history.branch_id','course.course_name','users.name',
                    'treat_history.dr_id', 'treat_history.bt_user_id1', 'treat_history.bt_user_id2','product.product_name','treat_history.comment',
                    'treat_history.treat_date')
            ->join('treat_history','treat_history.treat_id','=','treat_has_medicine.treat_id')
            ->join('product','product.product_id','=','treat_has_medicine.product_id')
            ->join('course','course.course_id','=','treat_history.course_id')
            ->join('quotations','quotations.quo_id','=','treat_history.quo_id')
            ->join('users','users.id','=','treat_history.emp_id')
            ->where('quotations.cus_id','=',$customer->cus_id)
            ->orderby('treat_id','desc')
            ->get();

         // return response()->json($data);

          return view('customer/view',['data'=>$customer,'treat'=>$data]);
    }



    public function getDataCustomer()
    {
        $customer = Customer::find($this->getCusID());
        $data = null;
        $data['id'] = $customer->cus_id; //รหัสลูกค้า
        $data['reg'] = $customer->cus_reg; //วันที่ลงทะเบียน
        $data['branch'] = $customer->branch_id; //สาขาที่สมัคร
        $data['full_name'] = $customer->cus_name . ' ' . $customer->cus_lastname; //ชื่อลูกค้า
        $data['id_card'] = $customer->cus_code; //รหัสบัตรประชาชน
        $data['birthday'] = $customer->cus_birthday_day . '/' . $customer->cus_birthday_month . '/' . $customer->cus_birthday_year; //วันเดือนปีเกิด
        $data['gender'] = $customer->cus_sex; // เพศ
        $data['blood'] = $customer->cus_blood; // เลือด
        $data['height'] = $customer->cus_height; //ส่วนสูง
        $data['weight'] = $customer->cus_weight; //น้ำหนัก
        $data['allergic'] = $customer->allergic; //โรคประจำตัว
        $data['disease'] = $customer->disease; //แพ้ยา
        $data['phone'] = $customer->cus_phone; //มือถือ
        $data['tel'] = $customer->cus_tel; //บ้าน
        $data['email'] = $customer->cus_email; //email
        $data['address'] = $customer->cus_hno . ' ' . $customer->cus_moo . ' ' . $customer->cus_soi . ' ' . //ที่อยู๋ บ้านเลขที่/หมู่/ซอย
            $customer->cus_road . ' ' . $customer->cus_subdis . ' ' . $customer->cus_district . ' ' . //ถนน/ตำบล/อำเถอ
            $customer->cus_province . ' ' . $customer->cus_postal; //จังหวัด/รหัสไปรษณ์
        return response()->json($data);
    }

    public function setCustomer()
    {
        $cus_id = \Input::get('id');
        $cus = Customer::findOrFail($this->getDataCustomer());
        $cus->cus_id = $cus_id;
        $cus->save();
        //dd($quo);
        return response()->json(['status' => 'success']);
    }

    public function getDataCourse()
    {
        $course = Course::find($this->getCouID());
        $data = null;
        $data['id'] = $course->id;
        $data['name'] = $course->name;
        return response()->json($data);
    }

    public function removeCustomer()
    {
        $quo = Customer::findOrFail($this->getDataCustomer());
        $quo->cus_id = 0;
        $quo->save();
        return redirect('customer');
    }



    public function getDataGrid()
    {
        $grid = DataGrid::source(new Customer());
        $grid->attributes(array("class" => "table table-hover"));
        $grid->attributes(array("class" => "table table-bordered"));
        $grid->add('cus_id', 'รหัสสมาชิก');
        $grid->add('cus_name', 'ชื่อ');
        $grid->add('cus_tel', 'เบอร์โทรศัพท์');
        $grid->add('{{$cus_id}}','รายละเอียด')->cell(function ($cus_id) {
            return '<a href="' . url('customer/view') . '?cus_id=' . $cus_id . '" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-edit"></i> ข้อมูลลูกค้า</a>';
        });
        $grid->edit('/customer/edit', 'กระทำ', 'modify|delete');

        return $grid;
    }

    public function grid()
    {
        $grid = $this->getDataGrid();

        return view('customer/index', compact('grid'));

    }

    public function create()
    {

        $form = DataEdit::source(new Customer());
        $form->text('cus_name', 'ชื่อ-นามสกุล')->rule('required')->attributes(array('placeholder' => 'โปรดระบุ ชื่อ-นามสกุล....'));
        $form->add('cus_birthday_day', 'วันเกิด', 'select')->options(Config::get('sex.day'))->rule('required');
        $form->add('cus_birthday_month', ' ', 'select')->options(Config::get('sex.month'))->rule('required');
        $form->add('cus_birthday_year', ' ', 'select')->options(Config::get('sex.year'))->rule('required');
        $form->add('cus_sex', 'เพศ', 'select')->options(Config::get('sex.sex'))->rule('required');
        $form->add('cus_blood', 'กรุ๊ปเลือด', 'select')->options(Config::get('sex.blood'))->rule('required');
        $form->text('cus_code', 'รหัสบัตรประชาชน')->rule('required|numeric|unique:customer,cus_code')->attributes(array('maxlength' => 13, 'minlength' => 13, 'placeholder' => 'โปรดระบุ เลขประจำตัวประชาชน....'));

        $form->text('cus_tel', 'เบอร์โทรศัพทมือถือ*')->rule('required|numeric')->attributes(array('placeholder' => '0xxxxxxxxxx'));
        $form->text('cus_phone', 'เบอร์โทรศัพท์บ้าน')->rule('numeric')->attributes(array('placeholder' => 'xxxxxx'));
        $form->text('cus_email', 'E-mail')->rule('required|email|unique:customer,cus_email')->attributes(array('placeholder' => 'demo@demo.com'));

        $form->text('cus_height', 'ส่วนสูง')->rule('required|numeric')->attributes(array('placeholder' => 'โปรดระบุ ส่วนสูง....'));
        $form->text('cus_weight', 'น้ำหนัก')->rule('required|numeric')->attributes(array('placeholder' => 'โปรดระบุ น้ำหนัก....'));

        $form->text('allergic', 'โรคประจำตัว')->attributes(array('data-role' => "tagsinput", 'placeholder' => 'โปรดระบุ โรคประจำตัว....'));
        $form->text('disease', 'แพ้ยา')->attributes(array('data-role' => "tagsinput", 'placeholder' => 'โปรดระบุ ยาที่แพ้....'));

        $form->text('cus_hno', 'บ้านเลขที่')->attributes(array('placeholder' => 'โปรดระบุ บ้านเลขที่....'));
        $form->text('cus_moo', 'หมู่')->attributes(array('placeholder' => 'โปรดระบุ หมู่....'));
        $form->text('cus_soi', 'ซอย/ตรอก')->attributes(array('placeholder' => 'โปรดระบุ ซอย....'));
        $form->text('cus_road', 'ถนน')->attributes(array('placeholder' => 'โปรดระบุ ถนน....'));
        $form->text('cus_subdis', 'ตำบล/แขวง')->attributes(array('placeholder' => 'โปรดระบุ ตำบล/แขวง....'));
        $form->text('cus_district', 'อำเภอ/เขต')->attributes(array('placeholder' => 'โปรดระบุ อำเภอ/เขต....'));
        $form->add('cus_province', 'จังหวัด', 'select')->options(Config::get('sex.province'))->rule('required');
        $form->text('cus_postal', 'รหัสไปรษณีย์')->rule('numeric')->attributes(array('placeholder' => 'โปรดระบุ รหัสไปรษณีย์....'))->rule('required');

        $form->attributes(array("class" => " "));


        $form->saved(function () use ($form) {

            $form->message("ลงทะเบียนเสร็จสิ้น");


        });
        $form->build();

        return view('customer/create', compact('form'));
    }

    public function edit()
    {
        if (Input::get('do_delete') == 1) return "not the first";

        $edit = DataEdit::source(new Customer());

        $edit->text('cus_name', 'ชื่อ-นามสกุล');
        $edit->add('cus_birthday_day', 'วันเกิด', 'select')->options(Config::get('sex.day'));
        $edit->add('cus_birthday_month', ' ', 'select')->options(Config::get('sex.month'));
        $edit->add('cus_birthday_year', ' ', 'select')->options(Config::get('sex.year'));
        $edit->add('cus_sex', 'เพศ', 'select')->options(Config::get('sex.sex'));
        $edit->add('cus_blood', 'กรุ๊ปเลือด', 'select')->options(Config::get('sex.blood'));
        $edit->text('cus_code', 'รหัสบัตรประชาชน')->rule('numeric');

        $edit->text('cus_tel', 'เบอร์โทรศัพทมือถือ')->rule('numeric');
        $edit->text('cus_phone', 'เบอร์โทรศัพท์บ้าน')->rule('numeric');
        $edit->text('cus_email', 'E-mail')->rule('email');

        $edit->text('cus_height', 'ส่วนสูง')->rule('numeric');
        $edit->text('cus_weight', 'น้ำหนัก')->rule('numeric');

        $edit->add('allergic', 'โรคประจำตัว', 'text')->attributes(array('data-role' => "tagsinput"));
        $edit->add('disease', 'แพ้ยา', 'text')->attributes(array('data-role' => "tagsinput"));

        $edit->text('cus_hno', 'บ้านเลขที่');
        $edit->text('cus_moo', 'หมู่');
        $edit->text('cus_soi', 'ซอย/ตรอก');
        $edit->text('cus_road', 'ถนน');
        $edit->text('cus_subdis', 'ตำบล/แขวง');
        $edit->text('cus_district', 'อำเภอ/เขต');
        $edit->add('cus_province', 'จังหวัด', 'select')->options(Config::get('sex.province'));
        $edit->text('cus_postal', 'รหัสไปรษณีย์');

        $edit->attributes(array("class" => " "));

        $edit->link("customer", "ย้อนกลับ");

        return $edit->view('customer/edit', compact('edit'));
    }


}
