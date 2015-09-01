<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:29
 */

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class VendorController extends Controller
{
    public function vendor(){
        return view("vendor/index");
    }

    public function getDataGrid(){
        $grid = DataGrid::source(new Vendor());
        $grid->attributes(array("class"=>"table table-bordered",'id'=>'data-table'));

        $grid->add('ven_id', 'รหัสร้านค้า')->style("width:100px");
        $grid->add('ven_name', 'ชื่อร้านค้า');
        $grid->add('ven_code', 'หมายเลขประจำตัวผู้เสียภาษี');
        $grid->add('ven_address', 'ที่อยู่ร้านค้า');
        $grid->add('ven_sell_name', 'ชื่อพนักงานขาย');
        $grid->add('ven_sell_tel', 'เบอร์โทรพนักงานขาย');

        $grid->edit('/vendor/edit', 'กระทำ','modify|delete');

        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();

        return view('vendor/index', compact('grid'));
    }


    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataEdit::source(new Vendor());
        $form->text('ven_id', 'รหัสร้านค้า')->rule('required|unique:vendor,ven_id')->attributes(array('placeholder'=>'โปรดระบุรหัสร้านค้า....'));
        $form->text('ven_name', 'ชื่อร้านค้า')->rule('required|unique:vendor,ven_name')->attributes(array('placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->text('ven_code', 'หมายเลขประจำตัวผู้เสียภาษี')->rule('required|unique:vendor,ven_code|numeric')->attributes(array('maxlength' => 13, 'minlength' => 13,'placeholder'=>'โปรดระบุหมายเลขประจำตัวผู้เสียภาษี....'));
        $form->textarea('ven_address', 'ที่อยู่ร้านค้า')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->text('ven_sell_name', 'ชื่อพนักงานขาย')->rule('required')->attributes(array('placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->text('ven_sell_tel', 'เบอร์โทรพนักงานขาย')->rule('required')->attributes(array('placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));

        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("vendor/index", "ย้อนกลับ");

        });

        return view('vendor/index', compact('form','grid'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Vendor());
        $edit->text('ven_id', 'รหัสร้านค้า');
        $edit->text('ven_name', 'ชื่อร้านค้า');
        $edit->text('ven_name', 'ชื่อร้านค้า');
        $edit->textarea('ven_address', 'ที่อยู่ร้านค้า')->attributes(array('rows'=>4));
        $edit->text('ven_sell_name', 'ชื่อพนักงานขาย');
        $edit->text('ven_sell_tel', 'เบอร์โทรพนักงานขาย');
        $edit->link("vendor/index", "ย้อนกลับ");
        $edit->attributes(array("class" => " "));
        $edit->saved(function () use ($edit) {
            systemLogs([
                'logs_type' => 'info' ,
                'logs_where'=> 'vendor',
                'emp_id' =>  auth()->user()->getAuthIdentifier(),
                'description'=>'แก้ไขร้านค้า รหัส : ' . Input::get('ven_id')
            ]);

        });

        return $edit->view('vendor/edit', compact('edit'));
    }


}