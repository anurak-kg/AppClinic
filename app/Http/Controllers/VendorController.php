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
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));

        $grid->add('ven_id', 'รหัสร้านค้า',true);
        $grid->add('ven_name', 'ชื่อร้านค้า');
        $grid->add('ven_address', 'ที่อยู่ร้านค้า');
        $grid->add('ven_sell_name', 'ชื่อพนักงานขาย');
        $grid->add('ven_sell_tel', 'เบอร์โทรพนักงานขาย');
        $grid->add('ven_discount_per', 'ส่วนลด %');
        $grid->add('ven_discount_amount', 'ส่วนลด บาท');
        $grid->edit('/vendor/edit', 'กระทำ','modify|delete');
        $grid->link('vendor/create',"เพิ่มข้อมูลใหม่", "TR");
        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('ven_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('vendor/index', compact('grid'));
    }


    public function create()
    {

        $form = DataEdit::create(new Vendor());
        $form->text('ven_id', 'รหัสร้านค้า')->rule('required')->attributes(array('maxlength'=>5,'placeholder'=>'โปรดระบุรหัสร้านค้า....'));
        $form->text('ven_name', 'ชื่อร้านค้า')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->textarea('ven_address', 'ที่อยู่ร้านค้า')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->text('ven_sell_name', 'ชื่อพนักงานขาย')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->text('ven_sell_tel', 'เบอร์โทรพนักงานขาย')->rule('required')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุที่อยู่ร้านค้า....'));
        $form->text('ven_discount_per', 'ส่วนลด %')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุส่วนลด %....'));
        $form->text('ven_discount_amount', 'ส่วนลด บาท')->rule('required')->attributes(array('maxlength'=>255,'placeholder'=>'โปรดระบุส่วนลด บาท....'));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("vendor/index", "ย้อนกลับ");

        });
        return view('vendor/create', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Vendor());
        $edit->text('ven_id', 'รหัสร้านค้า');
        $edit->text('ven_name', 'ชื่อร้านค้า');
        $edit->textarea('ven_address', 'ที่อยู่ร้านค้า');
        $edit->text('ven_sell_name', 'ชื่อพนักงานขาย');
        $edit->text('ven_sell_tel', 'เบอร์โทรพนักงานขาย');
        $edit->text('ven_discount_per', 'ส่วนลด %');
        $edit->text('ven_discount_amount', 'ส่วนลด บาท');
        $edit->attributes(array("class" => " "));


        return $edit->view('vendor/edit', compact('edit'));
    }


}