<?php

namespace App\Http\Controllers;

use App\Allergic_detail;
use App\Branch;
use App\Course;
use App\Customer;
use App\CustomerPhoto;
use App\Disease_detail;
use App\Payment;
use App\TreatHasMedicine;
use App\TreatHistory;
use Auth;
use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataForm;
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
            ->select('treat_history.treat_id', 'branch.branch_name', 'course.course_name', 'product.product_name', 'treat_has_medicine.qty'
                , DB::raw('(SELECT users.name from bt INNER JOIN users on users.id = bt.emp_id where bt.bt_type ="doctor") as dr')
                , DB::raw('(SELECT users.name from bt INNER JOIN users on users.id = bt.emp_id where bt.bt_type ="bt1") as bt1')
                , DB::raw('(SELECT users.name from bt INNER JOIN users on users.id = bt.emp_id where bt.bt_type ="bt2") as bt2')
                , 'treat_history.comment', 'treat_history.treat_date')
            ->join('treat_history', 'treat_history.treat_id', '=', 'treat_has_medicine.treat_id')
            ->join('product', 'product.product_id', '=', 'treat_has_medicine.product_id')
            ->join('course', 'course.course_id', '=', 'treat_history.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'treat_history.quo_id')
            ->join('branch', 'branch.branch_id', '=', 'treat_history.branch_id')
            ->where('quotations.cus_id', '=', $customer->cus_id)
            ->orderby('treat_date', 'asc')
            ->get();

        $datapayment = Payment::where('payment.cus_id', '=', $customer->cus_id)
            ->with('payment_detail')
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

        return view('customer/view', ['data' => $customer, 'treat' => $data, 'payment' => $datapayment, 'dataphotoBefore' => $dataphotoBefore, 'dataphotoAfter' => $dataphotoAfter]);
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
        foreach ($input['file'] as $file) {
            $extension = $file->getClientOriginalExtension(); // getting file extension
            $fileName = $cus_id . '-' . $type . '-' . rand(111111, 991999) . '.' . $extension; // renameing image
            $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
            $customerPhoto = new CustomerPhoto();
            $customerPhoto->emp_id = Auth::user()->getAuthIdentifier();
            $customerPhoto->branch_id = Branch::getCurrentId();
            $customerPhoto->cus_id = $cus_id;
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

    public function getJsonPhotoList()
    {
        $customerPhoto = CustomerPhoto::where('cus_id', Input::get('cus_id'))->where('photo_type', Input::get('type'))->get();
        $data = [];
        foreach ($customerPhoto as $photo) {
            array_push($data, [
                'name' => $photo->photo_file_name,
                'size' => 1024
            ]);
        }
        return response()->json($data);
    }

    public function getDeletePhotoById()
    {
        $filename = Input::get('filename');
        $customer_photo = CustomerPhoto::where('photo_file_name', $filename)->first();
        $customer_photo->delete();
        \File::delete(public_path() . '/uploads/customer/' . $filename);
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

        $form = DataForm::create('customer');
        $form->text('cus_name', trans("customer.name"))->rule('required')->attributes(array('placeholder' => 'โปรดระบุ ชื่อ-นามสกุล....'));
        $form->add('cus_birthday_day', trans("customer.birthday"), 'select')->options(Config::get('sex.day'))->rule('required');
        $form->add('cus_birthday_month', ' ', 'select')->options(Config::get('sex.month'))->rule('required');
        $form->add('cus_birthday_year', ' ', 'select')->options(Config::get('sex.year'))->rule('required');
        $form->add('cus_sex', trans("customer.gender"), 'select')->options(Config::get('sex.sex'))->rule('required');
        $form->add('cus_blood', trans("customer.blood"), 'select')->options(Config::get('sex.blood'))->rule('required');
        $form->text('cus_code', trans("customer.identification_Code"))->rule('required|numeric|unique:customer,cus_code')->attributes(array('maxlength' => 13, 'minlength' => 13, 'placeholder' => 'โปรดระบุ เลขประจำตัวประชาชน....'));
        $form->text('cus_tel', trans("customer.phone"))->rule('required|numeric')->attributes(array('placeholder' => '0xxxxxxxxxx'));
        $form->text('cus_phone', trans("customer.phone"))->rule('numeric')->attributes(array('placeholder' => 'xxxxxx'));
        $form->text('cus_email', trans("customer.email"))->rule('email|unique:customer,cus_email')->attributes(array('placeholder' => 'demo@demo.com'));
        $form->text('cus_height', trans("customer.height"))->rule('numeric')->attributes(array('placeholder' => 'โปรดระบุ ส่วนสูง....'));
        $form->text('cus_weight', trans("customer.weight"))->rule('numeric')->attributes(array('placeholder' => 'โปรดระบุ น้ำหนัก....'));
        $form->text('allergic', trans("customer.allergic"))->attributes(array('data-role' => "tagsinput", 'placeholder' => 'โปรดระบุ โรคประจำตัว....'));
        $form->text('disease', trans("customer.disease"))->attributes(array('data-role' => "tagsinput", 'placeholder' => 'โปรดระบุ ยาที่แพ้....'));
        $form->text('cus_hno', trans("customer.house_no"))->attributes(array('placeholder' => 'โปรดระบุ บ้านเลขที่....'));
        $form->text('cus_moo', trans("customer.village_no"))->attributes(array('placeholder' => 'โปรดระบุ หมู่....'));
        $form->text('cus_soi', trans("customer.lane"))->attributes(array('placeholder' => 'โปรดระบุ ซอย....'));
        $form->text('cus_road', trans("customer.road"))->attributes(array('placeholder' => 'โปรดระบุ ถนน....'));
        $form->text('cus_subdis', trans("customer.sub-district_sub-area"))->attributes(array('placeholder' => 'โปรดระบุ ตำบล/แขวง....'));
        $form->text('cus_district', trans("customer.district_area"))->attributes(array('placeholder' => 'โปรดระบุ อำเภอ/เขต....'));
        $form->add('cus_province', trans("customer.province"), 'select')->options(Config::get('sex.province'));
        $form->text('cus_postal', trans("customer.postal_code"))->attributes(array('placeholder' => 'โปรดระบุ รหัสไปรษณีย์....'));
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {
            $user = new Customer();
            $user->cus_id = getNewCustomerPK();
            $user->cus_name = Input::get('cus_name');
            $user->cus_birthday_day = Input::get('cus_birthday_day');
            $user->cus_birthday_month = Input::get('cus_birthday_month');
            $user->cus_birthday_year = Input::get('cus_birthday_year');
            $user->cus_sex = Input::get('cus_sex');
            $user->cus_blood = Input::get('cus_blood');
            $user->cus_code = Input::get('cus_code');
            $user->cus_tel = Input::get('cus_tel');
            $user->cus_phone = Input::get('cus_phone');
            $user->cus_email = Input::get('cus_email');
            $user->cus_height = Input::get('cus_height');
            $user->cus_weight = Input::get('cus_weight');
            $user->allergic = Input::get('allergic');
            $user->disease = Input::get('disease');
            $user->cus_hno = Input::get('cus_hno');
            $user->cus_moo = Input::get('cus_moo');
            $user->cus_soi = Input::get('cus_soi');
            $user->cus_road = Input::get('cus_road');
            $user->cus_subdis = Input::get('cus_subdis');
            $user->cus_district = Input::get('cus_district');
            $user->cus_province = Input::get('cus_province');
            $user->cus_postal = Input::get('cus_postal');
            $user->save();
            $form->message(trans("customer.registration finished"));

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier(),
                'cus_id' => $user->cus_id,
                'logs_type' => 'info',
                'logs_where' => 'Customer',
                'description' => 'เพิ่มสมาชิก : รหัสสมาชิก ' . $user->cus_id
            ]);
            $form->message(trans("customer.already_more_information"));
            $form->link("customer", trans("customer.back"));
        });
        $form->build();

        return view('customer/create', compact('form'));
    }

    public function delete()
    {
        $customer = Customer::findOrFail(Input::get('cus_id'));
        $customer->delete();
        return redirect('customer')->with('message', trans("customer.finished_delete"));

    }

    public function edit()
    {
        if (Input::get('do_delete') == 1) return "not the first";

        $edit = DataEdit::source(new Customer());

        $edit->text('cus_name', trans("customer.name"));
        $edit->add('cus_birthday_day', trans("customer.birthday"), 'select')->options(Config::get('sex.day'));
        $edit->add('cus_birthday_month', ' ', 'select')->options(Config::get('sex.month'));
        $edit->add('cus_birthday_year', ' ', 'select')->options(Config::get('sex.year'));
        $edit->add('cus_sex', trans("customer.gender"), 'select')->options(Config::get('sex.sex'));
        $edit->add('cus_blood', trans("customer.blood"), 'select')->options(Config::get('sex.blood'));
        $edit->text('cus_code', trans("customer.identification_Code"))->rule('numeric');
        $edit->text('cus_tel', trans("customer.phone"))->rule('numeric');
        $edit->text('cus_phone', trans("customer.phone"))->rule('numeric');
        $edit->text('cus_email', trans("customer.email"))->rule('email');
        $edit->text('cus_height', trans("customer.height"))->rule('numeric');
        $edit->text('cus_weight', trans("customer.weight"))->rule('numeric');
        $edit->add('allergic', trans("customer.allergic"), 'text')->attributes(array('data-role' => "tagsinput"));
        $edit->add('disease', trans("customer.disease"), 'text')->attributes(array('data-role' => "tagsinput"));
        $edit->add('cus_reference', trans("customer.source"), 'select')->options(['Web Site' => 'Web Site', 'Booth' => 'Booth', 'Offline' => 'Offline']);
        $edit->text('cus_hno', trans("customer.house_no"));
        $edit->text('cus_moo', trans("customer.village_no"));
        $edit->text('cus_soi', trans("customer.lane"));
        $edit->text('cus_road', trans("customer.road"));
        $edit->text('cus_subdis', trans("customer.sub-district_sub-area"));
        $edit->text('cus_district', trans("customer.district_area"));
        $edit->add('cus_province', trans("customer.province"), 'select')->options(Config::get('sex.province'));
        $edit->text('cus_postal', trans("customer.postal_code"));
        $edit->attributes(array("class" => " "));
        $edit->link("customer", trans("customer.back"));

        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier(),
                'logs_type' => 'info',
                'logs_where' => 'Customer',
                'description' => 'แก้ไขสมาชิก : ชื่อสมาชิก ' . Input::get('cus_name')
            ]);

        });
        return $edit->view('customer/edit', compact('edit'));
    }


}
