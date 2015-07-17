<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataForm;
use App\AuthenticatableContract;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;

class CustomerController extends Controller
{
    public function customer (){
        return view("customer/index");
    }

    public function getDataGrid()
    {
        $grid = DataGrid::source('customer');
        $grid->add('cus_id', 'รหัสลูกค้า',true);
        $grid->add('cus_name', 'ชื่อลูกค้า');
        $grid->add('cus_lastname', 'นามสกุลลูกค้า');
        $grid->add('cus_tel', 'เบอร์โทรศัพท์ลูกค้า');
        $grid->edit('/customer/edit', 'กระทำ','modify|delete');
        $grid->link('customer/create',"เพิ่มข้อมูลใหม่", "TR");
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
        $form->text('cus_id','รหัส')->rule('required|max:8');
        $form->text('cus_name', 'ชื่อ')->rule('required');
        $form->text('cus_lastname', 'นามสกุล')->rule('required');
        $form->text('cus_birthday','วันเดือนปีเกิด');
        $form->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'));
        $form->add('cus_blood','กรุ๊ปเลือด','select')->options(Config::get('sex.blood'));
        $form->text('cus_code','รหัสบัตรประชาชน')->rule('max:13');
        $form->text('cus_tel','เบอร์โทรศัพทมือถือ์')->rule('max:10');
        $form->text('cus_phone','เบอร์โทรศัพท์บ้าน');
        $form->text('cus_email','E-mail');
        $form->date('cus_reg','วันที่ลงทะเบียน');
        $form->text('cus_height','ส่วนสูง');
        $form->text('cus_weight','น้ำหนัก');
        $form->text('cus_hno','บ้านเลขที่');
        $form->text('cus_moo','หมู่');
        $form->text('cus_soi','ซอย');
        $form->text('cus_alley','ตรอก');
        $form->text('cus_road','ถนน');
        $form->text('cus_subdis','ตำบล/แขวง');
        $form->text('cus_district','อำเภอ/เขต');
        $form->text('cus_province','จังหวัด');
        $form->text('cus_postal','รหัสไปรษณีย์');
        $form->attributes(array("class" => " "));

        $form->link("customer/index", "ย้อนกลับ");

        $form->saved(function () use ($form) {
            $form->message("ลงทะเบียนเสร็จสิ้น");

        });
        $form->build();

        return view('customer/create', compact('form'));
    }


}
