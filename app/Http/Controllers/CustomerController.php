<?php

namespace App\Http\Controllers;

use App\Allergic_detail;
use App\Customer;
use App\Disease_detail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataForm;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;


class CustomerController extends Controller
{

    public function getDataGrid()
    {
        $grid = DataGrid::source(new Customer());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('cus_id', 'รหัสสมาชิก',true);
        $grid->add('cus_name', 'ชื่อ');
        $grid->add('cus_lastname', 'นามสกุล');
        $grid->add('cus_tel', 'เบอร์โทรศัพท์');
        $grid->add('created_at','วันที่ลงทะเบียน');
        $grid->edit('/customer/edit', 'กระทำ','modify|delete');

        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('cus_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('customer/index', compact('grid'));
    }

    public function create()
    {

        $form = DataEdit::source(new Customer());
        $form->text('cus_name','ชื่อ')->rule('required|unique:customer,cus_name')->attributes(array('placeholder'=>'โปรดระบุ ชื่อ....'));
        $form->text('cus_lastname','นามสกุล')->rule('required')->attributes(array('placeholder'=>'โปรดระบุ นามสกุล....'));
        $form->add('cus_birthday_day','วันเกิด','select')->options(Config::get('sex.day'))->rule('required');
        $form->add('cus_birthday_month',' ','select')->options(Config::get('sex.month'))->rule('required');
        $form->add('cus_birthday_year',' ','select')->options(Config::get('sex.year'))->rule('required');
        $form->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->add('cus_blood','กรุ๊ปเลือด','select')->options(Config::get('sex.blood'))->rule('required');
        $form->text('cus_code','รหัสบัตรประชาชน')->rule('required|numeric|unique:customer,cus_code')->attributes(array('maxlength'=>13,'minlength'=>13,'placeholder'=>'โปรดระบุ เลขประจำตัวประชาชน....'));

        $form->text('cus_tel','เบอร์โทรศัพทมือถือ*')->rule('required|numeric')->attributes(array('placeholder'=>'0xxxxxxxxxx'));
        $form->text('cus_phone','เบอร์โทรศัพท์บ้าน')->rule('numeric')->attributes(array('placeholder'=>'xxxxxx'));
        $form->text('cus_email','E-mail')->rule('required|email|unique:customer,cus_email')->attributes(array('placeholder'=>'demo@demo.com'));

        $form->text('cus_height','ส่วนสูง')->rule('required|numeric')->attributes(array('placeholder'=>'โปรดระบุ ส่วนสูง....'));
        $form->text('cus_weight','น้ำหนัก')->rule('required|numeric')->attributes(array('placeholder'=>'โปรดระบุ น้ำหนัก....'));

        $form->text('allergic','โรคประจำตัว')->attributes(array('data-role'=>"tagsinput",'placeholder'=>'โปรดระบุ โรคประจำตัว....'));
        $form->text('disease','แพ้ยา')->attributes(array('data-role'=>"tagsinput",'placeholder'=>'โปรดระบุ ยาที่แพ้....'));

        $form->text('cus_hno','บ้านเลขที่')->attributes(array('placeholder'=>'โปรดระบุ บ้านเลขที่....'));
        $form->text('cus_moo','หมู่')->attributes(array('placeholder'=>'โปรดระบุ หมู่....'));
        $form->text('cus_soi','ซอย/ตรอก')->attributes(array('placeholder'=>'โปรดระบุ ซอย....'));
        $form->text('cus_road','ถนน')->attributes(array('placeholder'=>'โปรดระบุ ถนน....'));
        $form->text('cus_subdis','ตำบล/แขวง')->attributes(array('placeholder'=>'โปรดระบุ ตำบล/แขวง....'));
        $form->text('cus_district','อำเภอ/เขต')->attributes(array('placeholder'=>'โปรดระบุ อำเภอ/เขต....'));
        $form->add('cus_province','จังหวัด','select')->options(Config::get('sex.province'))->rule('required');
        $form->text('cus_postal','รหัสไปรษณีย์')->rule('numeric')->attributes(array('placeholder'=>'โปรดระบุ รหัสไปรษณีย์....'))->rule('required');

        $form->attributes(array("class" => " "));



        $form->saved(function () use ($form) {

            $form->message("ลงทะเบียนเสร็จสิ้น");


        });
        $form->build();

        return view('customer/create', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Customer());
        
        $edit->text('cus_name','ชื่อ')->rule('unique:customer,cus_name');
        $edit->text('cus_lastname','นามสกุล');
        $edit->add('cus_birthday_day','วันเกิด','select')->options(Config::get('sex.day'));
        $edit->add('cus_birthday_month',' ','select')->options(Config::get('sex.month'));
        $edit->add('cus_birthday_year',' ','select')->options(Config::get('sex.year'));
        $edit->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'));
        $edit->add('cus_blood','กรุ๊ปเลือด','select')->options(Config::get('sex.blood'));
        $edit->text('cus_code','รหัสบัตรประชาชน')->rule('numeric|unique:customer,cus_code');

        $edit->text('cus_tel','เบอร์โทรศัพทมือถือ')->rule('numeric');
        $edit->text('cus_phone','เบอร์โทรศัพท์บ้าน')->rule('numeric');
        $edit->text('cus_email','E-mail')->rule('email|unique:customer,cus_email');

        $edit->text('cus_height','ส่วนสูง')->rule('numeric');
        $edit->text('cus_weight','น้ำหนัก')->rule('numeric');

        $edit->add('allergic','โรคประจำตัว','text')->attributes(array('data-role'=>"tagsinput"));
        $edit->add('disease','แพ้ยา','text')->attributes(array('data-role'=>"tagsinput"));

        $edit->text('cus_hno','บ้านเลขที่');
        $edit->text('cus_moo','หมู่');
        $edit->text('cus_soi','ซอย/ตรอก');
        $edit->text('cus_road','ถนน');
        $edit->text('cus_subdis','ตำบล/แขวง');
        $edit->text('cus_district','อำเภอ/เขต');
        $edit->add('cus_province','จังหวัด','select')->options(Config::get('sex.province'));
        $edit->text('cus_postal','รหัสไปรษณีย์');

        $edit->attributes(array("class" => " "));

        $edit->link("customer/index", "ย้อนกลับ");

        return $edit->view('customer/edit', compact('edit'));
    }

}
