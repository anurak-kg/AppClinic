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
        $form->text('cus_name','ชื่อ')->rule('required')->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ ชื่อ....'));
        $form->text('cus_lastname','นามสกุล')->rule('required')->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ นามสกุล....'));
        $form->add('cus_birthday_day','วันเกิด','select')->options(Config::get('sex.day'))->rule('required');
        $form->add('cus_birthday_month',' ','select')->options(Config::get('sex.month'))->rule('required');
        $form->add('cus_birthday_year',' ','select')->options(Config::get('sex.year'))->rule('required');
        $form->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->add('cus_blood','กรุ๊ปเลือด','select')->options(Config::get('sex.blood'))->rule('required');
        $form->text('cus_code','รหัสบัตรประชาชน')->rule('required|numeric')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุ เลขประจำตัวประชาชน....'));

        $form->text('cus_tel','เบอร์โทรศัพทมือถือ')->rule('required')->attributes(array('maxlength'=>10,'placeholder'=>'0xxxxxxxxxx'));
        $form->text('cus_phone','เบอร์โทรศัพท์บ้าน')->attributes(array('maxlength'=>10,'placeholder'=>'xxxxxx'));
        $form->text('cus_email','E-mail')->rule('required|email')->attributes(array('maxlength'=>200,'placeholder'=>'demo@demo.com'));
        $form->date('cus_reg','วันที่ลงทะเบียน')->format('d/m/Y','th')->attributes(array('placeholder'=>'โปรดเลือก วันที่ลงทะเบียน....'));
        $form->text('cus_height','ส่วนสูง')->rule('required|integer')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุ ส่วนสูง....'));
        $form->text('cus_weight','น้ำหนัก')->rule('required|integer')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุ น้ำหนัก....'));

        $form->add('dis_de_id','โรคประจำตัว','text')->options(Disease_detail::lists('dis_de_dis','dis_de_id')->toArray())->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ โรคประจำตัว....'));
        $form->add('gic_de_id','แพ้ยา','text')->options(Allergic_detail::lists('gic_de_id','gic_de_dis')->toArray())->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ ยาที่แพ้....'));

        $form->text('cus_hno','บ้านเลขที่')->attributes(array('placeholder'=>'โปรดระบุ บ้านเลขที่....'));
        $form->text('cus_moo','หมู่')->attributes(array('placeholder'=>'โปรดระบุ หมู่....'));
        $form->text('cus_soi','ซอย/ตรอก')->attributes(array('placeholder'=>'โปรดระบุ ซอย....'));
        $form->text('cus_road','ถนน')->attributes(array('placeholder'=>'โปรดระบุ ถนน....'));
        $form->text('cus_subdis','ตำบล/แขวง')->attributes(array('placeholder'=>'โปรดระบุ ตำบล/แขวง....'));
        $form->text('cus_district','อำเภอ/เขต')->attributes(array('placeholder'=>'โปรดระบุ อำเภอ/เขต....'));
        $form->add('cus_province','จังหวัด','select')->options(Config::get('sex.province'))->rule('required');
        $form->text('cus_postal','รหัสไปรษณีย์')->attributes(array('placeholder'=>'โปรดระบุ รหัสไปรษณีย์....'))->rule('required');

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
        
        $edit->text('cus_name','ชื่อ')->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ ชื่อ....'));
        $edit->text('cus_lastname','นามสกุล')->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ นามสกุล....'));
        $edit->add('cus_birthday_day','วันเกิด','select')->options(Config::get('sex.day'));
        $edit->add('cus_birthday_month',' ','select')->options(Config::get('sex.month'));
        $edit->add('cus_birthday_year',' ','select')->options(Config::get('sex.year'));
        $edit->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'));
        $edit->add('cus_blood','กรุ๊ปเลือด','select')->options(Config::get('sex.blood'));
        $edit->text('cus_code','รหัสบัตรประชาชน')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุ เลขประจำตัวประชาชน....'));

        $edit->text('cus_tel','เบอร์โทรศัพทมือถือ')->attributes(array('maxlength'=>10,'placeholder'=>'0xxxxxxxxxx'));
        $edit->text('cus_phone','เบอร์โทรศัพท์บ้าน')->attributes(array('maxlength'=>10,'placeholder'=>'xxxxxx'));
        $edit->text('cus_email','E-mail')->attributes(array('maxlength'=>200,'placeholder'=>'demo@demo.com'));
        $edit->date('cus_reg','วันที่ลงทะเบียน')->format('d/m/Y','th')->attributes(array('placeholder'=>'โปรดเลือก วันที่ลงทะเบียน....'));
        $edit->text('cus_height','ส่วนสูง')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุ ส่วนสูง....'));
        $edit->text('cus_weight','น้ำหนัก')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุ น้ำหนัก....'));

        $edit->add('dis_de_id','โรคประจำตัว','text')->options(Disease_detail::lists('dis_de_dis','dis_de_id')->toArray())->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ โรคประจำตัว....'));
        $edit->add('gic_de_id','แพ้ยา','text')->options(Allergic_detail::lists('gic_de_id','gic_de_dis')->toArray())->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ ยาที่แพ้....'));

        $edit->text('cus_hno','บ้านเลขที่')->attributes(array('placeholder'=>'โปรดระบุ บ้านเลขที่....'));
        $edit->text('cus_moo','หมู่')->attributes(array('placeholder'=>'โปรดระบุ หมู่....'));
        $edit->text('cus_soi','ซอย/ตรอก')->attributes(array('placeholder'=>'โปรดระบุ ซอย....'));
        $edit->text('cus_road','ถนน')->attributes(array('placeholder'=>'โปรดระบุ ถนน....'));
        $edit->text('cus_subdis','ตำบล/แขวง')->attributes(array('placeholder'=>'โปรดระบุ ตำบล/แขวง....'));
        $edit->text('cus_district','อำเภอ/เขต')->attributes(array('placeholder'=>'โปรดระบุ อำเภอ/เขต....'));
        $edit->add('cus_province','จังหวัด','select')->options(Config::get('sex.province'));
        $edit->text('cus_postal','รหัสไปรษณีย์')->attributes(array('placeholder'=>'โปรดระบุ รหัสไปรษณีย์....'));

        $edit->attributes(array("class" => " "));

        $edit->link("customer/index", "ย้อนกลับ");

        return $edit->view('customer/edit', compact('edit'));
    }

}
