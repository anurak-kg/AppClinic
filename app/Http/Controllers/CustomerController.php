<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Zofe\Rapyd\Facades\DataForm;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;

class CustomerController extends Controller
{
    public function newcus(){
        return view("customer/newcus");
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }
    public function getCustomerDataGrid()
    {
        $grid = DataGrid::source('customer');
        $grid->add('cus_id', 'รหัสลูกค้า');
        $grid->add('cus_name', 'ชื่อลูกค้า');
        $grid->add('cus_lastname', 'นามสกุลลูกค้า');
        $grid->add('cus_tel', 'เบอร์โทรศัพท์ลูกค้า');
        $grid->edit('/rapyd-demo/edit', 'Edit', 'show|modify');
        $grid->paginate(10);
        return $grid;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $grid = $this->getCustomerDataGrid();
        $form = DataForm::create();
        $form->text('cus_id','รหัส')->rule('required');
        $form->text('cus_name', 'ชื่อ')->rule('required');
        $form->text('cus_lastname', 'นามสกุล')->rule('required');
        $form->date('cus_birthday','วันเดือนปีเกิด')->rule('required');
        $form->add('cus_sex','เพศ','select')->options(Config::get('sex.sex'));
        $form->add('cus_blood','กรุ๊ปเลือด','select')->options('A','B','AB','O');
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
        $form->submit('Save');
        return view('customer/newcus', compact('form','grid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
