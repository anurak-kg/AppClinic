<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class ProductController extends Controller
{
    public function product(){
        return view("product/index");
    }

    public function getDataGrid(){
        $grid = DataGrid::source('product');
        $grid->attributes(array("class"=>"table table-striped"));
        $grid->add('product_id', 'รหัสสินค้า',true);
        $grid->add('pg_id', 'รหัสกลุ่มสินค้า',true);
        $grid->add('product_name', 'ชื่อสินค้า',true);
        $grid->add('product_qty', 'จำนวนสินค้าที่มี');
        $grid->add('product_qty_order', 'จำนวนสินค้าที่ถึงจุดสั่งซื้อ');
        $grid->add('product_date_start', 'วันที่ผลิต',true);
        $grid->add('product_date_end', 'วันที่หมดอายุ',true);
        $grid->add('product_price', 'ราคา/หน่วย');
        $grid->add('product_unit', 'หน่วยนับ',true);

        $grid->edit('/product/edit', 'กระทำ','modify|delete');
        $grid->link('product/create',"เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);


        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('product_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('product/index', compact('grid'));
    }


    public function create()
    {
        $form = DataForm::create();
        $form->text('product_id', 'รหัสสินค้า')->rule('required')->attributes(array('maxlength'=>3,'placeholder'=>'โปรดระบุรหัสสินค้า....'));
        $form->text('pg_id', 'รหัสกลุ่มสินค้า')->rule('required')->attributes(array('maxlength'=>30,'placeholder'=>'โปรดระบุรหัสกลุ่มสินค้า....'));
        $form->text('product_name', 'ชื่อสินค้า')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุชื่อสินค้า....'));
        $form->text('product_qty', 'จำนวนสินค้าที่มี')->rule('required')->attributes(array('maxlength'=>10,'placeholder'=>'โปรดระบุจำนวนสินค้าที่มี....'));
        $form->text('product_qty_order', 'จำนวนสินค้าที่ถึงจุดสั่งซื้อ')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุจำนวนสินค้าที่ถึงจุดสั่งซื้อ....'));
        $form->text('product_date_start', 'วันที่ผลิต')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบวันที่ผลิต....'));
        $form->text('product_date_end', 'วันที่หมดอายุ')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุวันที่หมดอายุ....'));
        $form->text('product_price', 'ราคา/หน่วย')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุราคา/หน่วย....'));
        $form->text('product_unit', 'หน่วยนับ')->rule('required')->attributes(array('maxlength'=>13,'placeholder'=>'โปรดระบุหน่วยนับ....'));
        $form->attributes(array("class" => " "));

        $form->submit('บันทึก');
        $form->link("product/index", "ย้อนกลับ");

        $form->saved(function () use ($form) {
            $user = new Product();
            $user->product_id = Input::get('product_id');
            $user->pg_id = Input::get('pg_id');
            $user->product_name = Input::get('product_name');
            $user->product_qty = Input::get('product_qty');
            $user->product_qty_order = Input::get('product_qty_order');
            $user->product_date_end = Input::get('product_date_end');
            $user->product_price = Input::get('product_price');
            $user->product_unit = Input::get('product_unit');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");
        });

        return view('product/create', compact('form'));
    }

   /* public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source('branch');
        $edit->link("branch/index","บันทึก", "TR")->back();


        $edit->add('branch_id', 'รหัสสาขา','text');
        $edit->add('branch_name', 'ชื่อสาขา','text');
        $edit->add('branch_address', 'ที่อยู่สาขา','textarea');
        $edit->add('branch_tel', 'เบอร์โทร','text');
        $edit->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี','text');


        return $edit->view('branch/edit', compact('edit'));
    }*/

}
