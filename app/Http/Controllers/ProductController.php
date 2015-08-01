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
        $grid = DataGrid::source(new Product());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('product_id', 'รหัสสินค้า',true);
        $grid->add('pg_id', 'รหัสกลุ่มสินค้า');
        $grid->add('product_name', 'ชื่อสินค้า');
        $grid->add('product_qty', 'inventory');
        $grid->add('product_qty_order', 'Order point');
        //$grid->add('product_date_start', 'วันที่ผลิต');
        $grid->add('product_date_end', 'วันที่หมดอายุ');
        $grid->add('product_price', 'ราคา/หน่วย');
        $grid->add('product_unit', 'หน่วยนับ');
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
        $form = DataEdit::create(new Product());
        $form->text('product_id', 'รหัสสินค้า')->rule('required')->attributes(array('placeholder'=>'โปรดระบุรหัสสินค้า....'));
        $form->text('pg_id', 'รหัสกลุ่มสินค้า')->rule('required')->attributes(array('placeholder'=>'โปรดระบุรหัสกลุ่มสินค้า....'));
        $form->text('product_name', 'ชื่อสินค้า')->rule('required')->attributes(array('rows'=>4,'placeholder'=>'โปรดระบุชื่อสินค้า....'));
        $form->text('product_qty', 'จำนวนสินค้าที่มี')->rule('required|integer')->attributes(array('placeholder'=>'โปรดระบุจำนวนสินค้าที่มี....'));
        $form->text('product_qty_order', 'จำนวนสินค้าที่ถึงจุดสั่งซื้อ')->rule('required|integer')->attributes(array('placeholder'=>'โปรดระบุจำนวนสินค้าที่ถึงจุดสั่งซื้อ....'));
        $form->date('product_date_start', 'วันที่ผลิต')->format('d/m/Y','th')->rule('required')->attributes(array('placeholder'=>'โปรดระบวันที่ผลิต....'));
        $form->date('product_date_end', 'วันที่หมดอายุ')->format('d/m/Y','th')->rule('required')->attributes(array('placeholder'=>'โปรดระบุวันที่หมดอายุ....'));
        $form->text('product_price', 'ราคา/หน่วย')->rule('required|integer')->attributes(array('placeholder'=>'โปรดระบุราคา/หน่วย....'));
        $form->text('product_unit', 'หน่วยนับ')->rule('required')->attributes(array('placeholder'=>'โปรดระบุหน่วยนับ....'));
        $form->attributes(array("class" => " "));




        $form->saved(function () use ($form) {
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("product/index", "ย้อนกลับ");
        });

        return view('product/create', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Product());
        $edit->link("branch/index","บันทึก", "TR")->back();

        $edit->text('product_id', 'รหัสสินค้า');
        $edit->text('pg_id', 'รหัสกลุ่มสินค้า');
        $edit->text('product_name', 'ชื่อสินค้า');
        $edit->text('product_qty', 'จำนวนสินค้าที่มี');
        $edit->text('product_qty_order', 'จำนวนสินค้าที่ถึงจุดสั่งซื้อ');
        $edit->date('product_date_start', 'วันที่ผลิต');
        $edit->date('product_date_end', 'วันที่หมดอายุ');
        $edit->text('product_price', 'ราคา/หน่วย');
        $edit->text('product_unit', 'หน่วยนับ');
        $edit->attributes(array("class" => " "));


        return $edit->view('product/edit', compact('edit'));
    }

}
