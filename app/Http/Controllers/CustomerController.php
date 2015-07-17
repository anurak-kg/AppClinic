<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;

class CustomerController extends Controller
{

    public function getDataGrid()
    {
        $grid = DataGrid::source('customer');
        $grid->add('cus_id', 'รหัสลูกค้า',true);
        $grid->add('cus_name', 'ชื่อลูกค้า');
        $grid->add('cus_lastname', 'นามสกุลลูกค้า');
        $grid->add('cus_tel', 'เบอร์โทรศัพท์ลูกค้า');
        $grid->edit('/customer/edit', 'กระทำ','show|modify|delete');

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
        $form->text('cus_name', 'ชื่อ')->rule('required')->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ ชื่อ....'));
        $form->text('cus_lastname', 'นามสกุล')->rule('required')->attributes(array('maxlength'=>100,'placeholder'=>'โปรดระบุ นามสกุล....'));
        $form->date('cus_birthday','วันเดือนปีเกิด')->format('d/m/Y','th')->attributes(array('placeholder'=>'โปรดเลือก วันเดือนปีเกิด....'));
        $form->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'));
        $form->add('cus_blood','กรุ๊ปเลือด','select')->options(Config::get('sex.blood'));
        $form->text('cus_code','รหัสบัตรประชาชน')->rule('required|integer')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุ เลขประจำตัวประชาชน....'));

        $form->text('cus_tel','เบอร์โทรศัพทมือถือ')->rule('required')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุ เบอร์โทรศัพท์มือถือ....'));
        $form->text('cus_phone','เบอร์โทรศัพท์บ้าน')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุ เบอร์โทรศัพท์บ้าน....'));
        $form->text('cus_email','E-mail')->rule('required|email')->attributes(array('maxlength'=>200,'placeholder'=>'โปรดระบุ E-mail....'));
        $form->date('cus_reg','วันที่ลงทะเบียน')->format('d/m/Y','th')->attributes(array('placeholder'=>'โปรดเลือก วันที่ลงทะเบียน....'));
        $form->text('cus_height','ส่วนสูง')->rule('required|intger')->attributes(array('placeholder'=>'โปรดระบุ ส่วนสูง....'));
        $form->text('cus_weight','น้ำหนัก')->rule('required|integer')->attributes(array('placeholder'=>'โปรดระบุ น้ำหนัก....'));

        $form->text('cus_hno','บ้านเลขที่')->attributes(array('placeholder'=>'โปรดระบุ บ้านเลขที่....'));
        $form->text('cus_moo','หมู่')->attributes(array('placeholder'=>'โปรดระบุ หมู่....'));
        $form->text('cus_soi','ซอย')->attributes(array('placeholder'=>'โปรดระบุ ซอย....'));
        $form->text('cus_alley','ตรอก')->attributes(array('placeholder'=>'โปรดระบุ ตรอก....'));
        $form->text('cus_road','ถนน')->attributes(array('placeholder'=>'โปรดระบุ ถนน....'));
        $form->text('cus_subdis','ตำบล/แขวง')->attributes(array('placeholder'=>'โปรดระบุ ตำบล/แขวง....'));
        $form->text('cus_district','อำเภอ/เขต')->attributes(array('placeholder'=>'โปรดระบุ อำเภอ/เขต....'));
        $form->text('cus_province','จังหวัด')->attributes(array('placeholder'=>'โปรดระบุ จังหวัด....'));
        $form->text('cus_postal','รหัสไปรษณีย์')->attributes(array('placeholder'=>'โปรดระบุ รหัสไปรษณีย์....'));

        $form->attributes(array("class" => " "));



        $form->saved(function () use ($form) {
            $form->message("ลงทะเบียนเสร็จสิ้น");

        });
        $form->build();

        return view('customer/create', compact('form'));
    }


}
