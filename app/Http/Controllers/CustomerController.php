<?php

namespace App\Http\Controllers;

use App\Allergic_detail;
use App\Branch;
use App\Course;
use App\Customer;
use App\CustomerPhoto;
use App\Disease_detail;
use Auth;
use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer/index', compact('customers'));
    }


    public function view()
    {
        $customer = Customer::with('Quotations.course')->where('cus_id', \Input::get('cus_id'))->get()->first();

        $data = \DB::table('treat_has_medicine')
            ->select('treat_history.treat_id', 'treat_history.branch_id', 'course.course_name', 'users.name',
                'treat_history.dr_id', 'treat_history.bt_user_id1', 'treat_history.bt_user_id2', 'product.product_name', 'treat_history.comment',
                'treat_history.treat_date')
            ->join('treat_history', 'treat_history.treat_id', '=', 'treat_has_medicine.treat_id')
            ->join('product', 'product.product_id', '=', 'treat_has_medicine.product_id')
            ->join('course', 'course.course_id', '=', 'treat_history.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'treat_history.quo_id')
            ->join('users', 'users.id', '=', 'treat_history.emp_id')
            ->where('quotations.cus_id', '=', $customer->cus_id)
            ->orderby('treat_id', 'desc')
            ->get();

        $datapayment = DB::table('payment_detail')
            ->select('payment_detail.branch_id', 'payment_detail.bank_id','payment_detail.payment_id',
                'payment_detail.payment_type','payment_detail.amount','payment_detail.card_id','payment_detail.edc_id',
                DB::raw('date(payment_detail.created_at) as date'))
            ->join('payment','payment.payment_id','=','payment_detail.payment_id')
            ->where('payment.cus_id', '=', $customer->cus_id)
            ->orderby('payment_id', 'desc')
            ->get();

        $dataphotoBefore = \DB::table('customer_photo')
            ->select('customer_photo.photo_file_name')
            ->where('customer_photo.cus_id', '=', $customer->cus_id)
            ->whereRaw('customer_photo.photo_type = "Before"')
            ->get();

        $dataphotoAfter = \DB::table('customer_photo')
            ->select('customer_photo.photo_file_name')
            ->where('customer_photo.cus_id', '=', $customer->cus_id)
            ->whereRaw('customer_photo.photo_type = "After"')
            ->get();


      //return response()->json($datapayment);

        return view('customer/view', ['data' => $customer, 'treat' => $data,'payment' => $datapayment,'dataphotoBefore'=>$dataphotoBefore,'dataphotoAfter'=>$dataphotoAfter]);
    }

    public function upload()
    {
        $customer = Customer::findOrFail(Input::get('cus_id'));
        return view('customer.upload', compact('customer'));
    }

    public function uploadFiles()
    {

        $input = Input::all();

        $rules = array(
           // 'file' => 'image',
            'customer_id' => 'required',
            'type' => 'required',

        );

        $validation = Validator::make($input, $rules);
        //dd($input);
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
        $cus_id = Input::get('customer_id');
        $type = Input::get('type');
        $destinationPath = 'uploads/customer'; // upload path
        $upload_success = null;
        foreach($input['file'] as $file ){
            $extension = $file->getClientOriginalExtension(); // getting file extension
            $fileName = $cus_id .'-'.$type.'-'.rand(111111, 991999) . '.' . $extension; // renameing image
            $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
            $customerPhoto = new CustomerPhoto();
            $customerPhoto->emp_id = Auth::user()->getAuthIdentifier();
            $customerPhoto->branch_id =  Branch::getCurrentId();
            $customerPhoto->cus_id =  $cus_id;
            $customerPhoto->photo_type = $type;
            $customerPhoto->photo_file_name = $fileName;
            $customerPhoto->save();
        }

        if ($upload_success) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
    }
    public function getJsonPhotoList(){
        $customerPhoto = CustomerPhoto::where('cus_id',Input::get('cus_id'))->where('photo_type',Input::get('type'))->get();
        $data = [];
        foreach($customerPhoto as $photo){
            array_push($data,[
                'name'=> $photo->photo_file_name,
                'size'=>1024
            ]);
        }
        return response()->json($data);
    }
    public function getDeletePhotoById(){
        $filename=Input::get('filename');
        $customer_photo = CustomerPhoto::where('photo_file_name',$filename)->first();
        $customer_photo->delete();
        \File::delete(public_path().'/uploads/customer/'.$filename);
        return Response::json('success', 200);
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
        $grid->add('{{$cus_id}}', 'รายละเอียด')->cell(function ($cus_id) {
            return '<a href="' . url('customer/view') . '?cus_id=' . $cus_id . '" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-edit"></i> ข้อมูลลูกค้า</a>';
        });
        $grid->add('cus_id', 'รายละเอียด')->cell(function ($cus_id) {
            return '<a href="' . url('customer/upload') . '?cus_id=' . $cus_id . '" class="btn btn-xs btn-primary" target="_blank"><i class="glyphicon glyphicon-edit"></i> ข้อมูลลูกค้า</a>';
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

        $form->text('cus_height', 'ส่วนสูง')->rule('numeric')->attributes(array('placeholder' => 'โปรดระบุ ส่วนสูง....'));
        $form->text('cus_weight', 'น้ำหนัก')->rule('numeric')->attributes(array('placeholder' => 'โปรดระบุ น้ำหนัก....'));

        $form->text('allergic', 'โรคประจำตัว')->attributes(array('data-role' => "tagsinput", 'placeholder' => 'โปรดระบุ โรคประจำตัว....'));
        $form->text('disease', 'แพ้ยา')->attributes(array('data-role' => "tagsinput", 'placeholder' => 'โปรดระบุ ยาที่แพ้....'));

        $form->text('cus_hno', 'บ้านเลขที่')->attributes(array('placeholder' => 'โปรดระบุ บ้านเลขที่....'));
        $form->text('cus_moo', 'หมู่')->attributes(array('placeholder' => 'โปรดระบุ หมู่....'));
        $form->text('cus_soi', 'ซอย/ตรอก')->attributes(array('placeholder' => 'โปรดระบุ ซอย....'));
        $form->text('cus_road', 'ถนน')->attributes(array('placeholder' => 'โปรดระบุ ถนน....'));
        $form->text('cus_subdis', 'ตำบล/แขวง')->attributes(array('placeholder' => 'โปรดระบุ ตำบล/แขวง....'));
        $form->text('cus_district', 'อำเภอ/เขต')->attributes(array('placeholder' => 'โปรดระบุ อำเภอ/เขต....'));
        $form->add('cus_province', 'จังหวัด', 'select')->options(Config::get('sex.province'));
        $form->text('cus_postal', 'รหัสไปรษณีย์')->attributes(array('placeholder' => 'โปรดระบุ รหัสไปรษณีย์....'));

        $form->attributes(array("class" => " "));



        $form->saved(function () use ($form) {
            $user = new Customer();
            $user->cus_id = Input::get('cus_id');
            $user->save();
            $form->message("ลงทะเบียนเสร็จสิ้น");

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'cus_id' => $user->cus_id,
                'logs_type' => 'info' ,
                'logs_where'=>'Course_type',
                'description'=>'เพิ่มสมาชิก : รหัสสมาชิก '.$user->cus_id
            ]);

        });
        $form->build();

        return view('customer/create', compact('form'));
    }
    public function delete(){
        $customer = Customer::findOrFail(Input::get('cus_id'));
        $customer->delete();
        return redirect('customer')->with('message', 'ลบข้อมูลลูกค้าเรียบร้อยแล้ว');

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
        $edit->add('cus_reference', 'แหล่งที่มา', 'select')->options(['Web Site' => 'Web Site', 'Booth' => 'Booth', 'Offline' => 'Offline']);

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

        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Course_type',
                'description'=>'แก้ไขสมาชิก : ชื่อสมาชิก ' . Input::get('cus_name')
            ]);

        });
        return $edit->view('customer/edit', compact('edit'));
    }


}
